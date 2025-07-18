<?php

namespace app\api\extends;

class DocumentToImage
{
    /**
     * 临时文件目录
     * @var mixed|string
     */
    private string $tempDir;

    /**
     * 输出文件路径
     * @var mixed|string
     */
    private  string $outputDir;

    public function __construct($tempDir = null, $outputDir = null)
    {
        $this->tempDir = $tempDir ?: sys_get_temp_dir();
        $this->outputDir = $outputDir ?: './public/uploads/converted/';

        // 确保目录存在
        if (!is_dir($this->outputDir)) {
            mkdir($this->outputDir, 0755, true);
        }
    }

    /**
     * 转换文档为图片
     */
    public function convertToImages($filePath, $options = [])
    {
        $fileExt = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        $defaultOptions = [
            'pages' => 'all',
            'dpi' => 150,
            'format' => 'jpg',
            'quality' => 90,
            'width' => null,
            'height' => null,
        ];

        $options = array_merge($defaultOptions, $options);

        try {
            switch ($fileExt) {
                case 'pdf':
                    return $this->convertPdfToImages($filePath, $options);
                case 'doc':
                case 'docx':
                    return $this->convertDocToImages($filePath, $options);
                default:
                    throw new \Exception("不支持的文件格式: {$fileExt}");
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'data' => []
            ];
        }
    }

    /**
     * PDF转图片 - 多种方案
     */
    private function convertPdfToImages($filePath, $options)
    {
        // 方案1: 尝试使用修复后的 Imagick
        try {
            return $this->convertPdfWithImagick($filePath, $options);
        } catch (\Exception $e) {
            // 如果 Imagick 失败，尝试其他方案
            error_log("Imagick 转换失败: " . $e->getMessage());
        }

        // 方案2: 使用 Ghostscript
        try {
            return $this->convertPdfWithGhostscript($filePath, $options);
        } catch (\Exception $e) {
            error_log("Ghostscript 转换失败: " . $e->getMessage());
        }

        // 方案3: 使用 poppler-utils (pdftoppm)
        try {
            return $this->convertPdfWithPoppler($filePath, $options);
        } catch (\Exception $e) {
            error_log("Poppler 转换失败: " . $e->getMessage());
        }

        throw new \Exception("所有 PDF 转换方案都失败了");
    }

    /**
     * 使用修复后的 Imagick 转换 PDF
     */
    private function convertPdfWithImagick($filePath, $options)
    {
        if (!extension_loaded('imagick')) {
            throw new \Exception('Imagick 扩展未安装');
        }

        // 检查 PDF 支持
        $formats = \Imagick::queryFormats("PDF");
        if (empty($formats)) {
            throw new \Exception('Imagick 不支持 PDF 格式');
        }

        $imagick = new \Imagick();

        try {
            // 设置分辨率
            $imagick->setResolution($options['dpi'], $options['dpi']);
            
            // 设置渲染质量
            $imagick->setImageAlphaChannel(\Imagick::ALPHACHANNEL_ACTIVATE);
            $imagick->setImageBackgroundColor('white');
            $imagick->setImageCompressionQuality(100);
            $imagick->setImageCompression(\Imagick::COMPRESSION_LOSSLESS);
            
            // 读取 PDF
            $imagick->readImage($filePath);

            // 获取总页数
            $totalPages = $imagick->getNumberImages();
            $pages = $this->parsePageNumbers($options['pages'], $totalPages);

            $results = [];
            $iterator = $imagick->getIterator();

            foreach ($iterator as $pageIndex => $page) {
                $currentPage = $pageIndex + 1;

                if (!in_array($currentPage, $pages)) {
                    continue;
                }

                // 设置图片格式
                $page->setImageFormat($options['format']);

                // 设置背景色为白色
                $page->setImageBackgroundColor('white');
                $page->setImageAlphaChannel(\Imagick::ALPHACHANNEL_REMOVE);

                // 调整尺寸
                if ($options['width'] || $options['height']) {
                    $page->resizeImage(
                        $options['width'] ?: 0,
                        $options['height'] ?: 0,
                        \Imagick::FILTER_LANCZOS,
                        1,
                        !($options['width'] && $options['height'])
                    );
                }

                // 设置质量
                if ($options['format'] === 'jpg') {
                    $page->setImageCompressionQuality($options['quality']);
                }

                // 生成文件名
                $filename = $this->generateFilename($filePath, $currentPage, $options['format']);
                $outputPath = $this->outputDir . $filename;

                // 保存图片
                $page->writeImage($outputPath);

                $results[] = [
                    'page' => $currentPage,
                    'filename' => $filename,
                    'path' => $outputPath,
                    'url' => $this->getFileUrl($filename),
                    'size' => filesize($outputPath)
                ];
            }

            $imagick->clear();
            $imagick->destroy();

            return [
                'success' => true,
                'message' => '转换成功 (使用 Imagick)',
                'data' => [
                    'total_pages' => $totalPages,
                    'converted_pages' => count($results),
                    'images' => $results
                ]
            ];
        } catch (\Exception $e) {
            $imagick->clear();
            $imagick->destroy();
            throw $e;
        }
    }

    /**
     * 使用 Ghostscript 转换 PDF
     */
    private function convertPdfWithGhostscript($filePath, $options)
    {
        if (!$this->commandExists('gs')) {
            throw new \Exception('Ghostscript 未安装');
        }

        $totalPages = $this->getPdfPageCount($filePath);
        $pages = $this->parsePageNumbers($options['pages'], $totalPages);
        $results = [];

        foreach ($pages as $pageNum) {
            $filename = $this->generateFilename($filePath, $pageNum, $options['format']);
            $outputPath = $this->outputDir . $filename;

            $device = $options['format'] === 'png' ? 'png16m' : 'jpeg';
            $quality = $options['format'] === 'jpg' ? '-dJPEGQ=' . $options['quality'] : '';
            $command = sprintf(
                'gs -dNOPAUSE -dBATCH -dSAFER -sDEVICE=%s -r%d -dTextAlphaBits=4 -dGraphicsAlphaBits=4 -dUseCIEColor=true %s -dFirstPage=%d -dLastPage=%d -sOutputFile=%s %s 2>&1',
                $device,
                $options['dpi'],
                $quality,
                $pageNum,
                $pageNum,
                escapeshellarg($outputPath),
                escapeshellarg($filePath)
            );

            $output = [];
            $returnCode = 0;
            exec($command, $output, $returnCode);

            if ($returnCode !== 0) {
                throw new \Exception("Ghostscript 转换失败: " . implode("\n", $output));
            }

            if (file_exists($outputPath)) {
                $results[] = [
                    'page' => $pageNum,
                    'filename' => $filename,
                    'path' => $outputPath,
                    'url' => $this->getFileUrl($filename),
                    'size' => filesize($outputPath)
                ];
            }
        }

        return [
            'success' => true,
            'message' => '转换成功 (使用 Ghostscript)',
            'data' => [
                'total_pages' => $totalPages,
                'converted_pages' => count($results),
                'images' => $results
            ]
        ];
    }

    /**
     * 使用 Poppler 转换 PDF
     */
    private function convertPdfWithPoppler($filePath, $options)
    {
        if (!$this->commandExists('pdftoppm')) {
            throw new \Exception('Poppler-utils 未安装');
        }

        $totalPages = $this->getPdfPageCount($filePath);
        $pages = $this->parsePageNumbers($options['pages'], $totalPages);

        $results = [];
        $tempPrefix = $this->tempDir . '/' . uniqid();

        foreach ($pages as $pageNum) {
            $format = $options['format'] === 'png' ? 'png' : 'jpeg';
            $command = sprintf(
                'pdftoppm -f %d -l %d -r %d -%s %s %s 2>&1',
                $pageNum,
                $pageNum,
                $options['dpi'],
                $format,
                escapeshellarg($filePath),
                escapeshellarg($tempPrefix)
            );

            $output = [];
            $returnCode = 0;
            exec($command, $output, $returnCode);

            if ($returnCode !== 0) {
                throw new \Exception("Poppler 转换失败: " . implode("\n", $output));
            }

            // 查找生成的文件
            $pattern = $tempPrefix . '-' . sprintf('%06d', $pageNum) . '.' . $format;
            if (file_exists($pattern)) {
                $filename = $this->generateFilename($filePath, $pageNum, $options['format']);
                $outputPath = $this->outputDir . $filename;

                rename($pattern, $outputPath);

                $results[] = [
                    'page' => $pageNum,
                    'filename' => $filename,
                    'path' => $outputPath,
                    'url' => $this->getFileUrl($filename),
                    'size' => filesize($outputPath)
                ];
            }
        }

        return [
            'success' => true,
            'message' => '转换成功 (使用 Poppler)',
            'data' => [
                'total_pages' => $totalPages,
                'converted_pages' => count($results),
                'images' => $results
            ]
        ];
    }

    /**
     * DOC/DOCX 转图片
     */
    private function convertDocToImages($filePath, $options)
    {
        // 先转换为 PDF
        $pdfPath = $this->convertDocToPdf($filePath);

        try {
            $result = $this->convertPdfToImages($pdfPath, $options);

            // 修改消息显示转换链
            if ($result['success']) {
                $result['message'] = '转换成功 (DOC->PDF->图片)';
            }

            return $result;
        } finally {
            // 清理临时 PDF 文件
            if (file_exists($pdfPath)) {
                unlink($pdfPath);
            }
        }
    }

    // /**
    //  * DOC/DOCX 转 PDF
    //  */
    // private function convertDocToPdf($filePath)
    // {
    //     $pdfPath = $this->tempDir . '/' . uniqid() . '.pdf';

    //     // 方案1: LibreOffice
    //     if ($this->commandExists('libreoffice')) {
    //         $command = sprintf(
    //             'libreoffice --headless --convert-to pdf --outdir %s %s 2>&1',
    //             escapeshellarg(dirname($pdfPath)),
    //             escapeshellarg($filePath)
    //         );

    //         $output = [];
    //         $returnCode = 0;
    //         exec($command, $output, $returnCode);

    //         $originalName = pathinfo($filePath, PATHINFO_FILENAME);
    //         $generatedPdf = dirname($pdfPath) . '/' . $originalName . '.pdf';

    //         if (file_exists($generatedPdf)) {
    //             rename($generatedPdf, $pdfPath);
    //             return $pdfPath;
    //         }
    //     }

    //     // 方案2: unoconv
    //     if ($this->commandExists('unoconv')) {
    //         $command = sprintf(
    //             'unoconv -f pdf -o %s %s 2>&1',
    //             escapeshellarg($pdfPath),
    //             escapeshellarg($filePath)
    //         );
    //         $output = [];
    //         $returnCode = 0;
    //         exec($command, $output, $returnCode);
    //         var_dump($output);
    //         var_dump($returnCode);
    //         if ($returnCode === 0 && file_exists($pdfPath)) {
    //             return $pdfPath;
    //         }
    //     }

    //     throw new \Exception('无法转换 DOC 文件，请安装 LibreOffice 或 unoconv');
    // }


    /**
     * DOC/DOCX 转 PDF
     * 
     * @param string $filePath 源文档文件路径
     * @return string 转换后的PDF文件路径
     * @throws \Exception 转换失败时抛出异常
     */
    private function convertDocToPdf($filePath)
    {
        // 验证源文件
        if (!file_exists($filePath) || !is_readable($filePath)) {
            throw new \Exception('源文件不存在或不可读: ' . $filePath);
        }

        // 确保临时目录存在
        if (!is_dir($this->tempDir) && !mkdir($this->tempDir, 0755, true)) {
            throw new \Exception('无法创建临时目录: ' . $this->tempDir);
        }

        // 创建唯一的PDF输出路径
        $pdfPath = $this->tempDir . '/' . uniqid('doc_', true) . '.pdf';

        // 处理中文文件名问题 - 创建ASCII名称的临时副本
        $tempFilePath = $this->createAsciiTempFile($filePath);

        $conversionSuccess = false;
        $conversionLog = [];

        try {
            // 方案1: 使用LibreOffice转换
            if (!$conversionSuccess && $this->commandExists('libreoffice')) {
                $conversionLog[] = "尝试使用LibreOffice转换...";

                $outDir = dirname($pdfPath);
                $tempFileName = pathinfo($tempFilePath, PATHINFO_FILENAME);
                $expectedOutput = $outDir . '/' . $tempFileName . '.pdf';

                $command = sprintf(
                    'timeout 180 libreoffice --headless --convert-to "pdf:writer_pdf_Export:EmbedStandardFonts=true;EmbedFonts=true;ExportNotes=false;UseReferenceXObject=false;ExportFormFields=false;FormsType=0;ReduceImageResolution=false;UseLosslessCompression=true;Quality=100;TextAndLineArt=3" --outdir %s %s 2>&1',
                    escapeshellarg($outDir),
                    escapeshellarg($tempFilePath)
                );

                $output = [];
                $returnCode = 0;
                exec($command, $output, $returnCode);

                $conversionLog[] = "LibreOffice命令: " . $command;
                $conversionLog[] = "返回代码: " . $returnCode;
                $conversionLog[] = "输出: " . implode("\n", $output);

                // LibreOffice生成的PDF文件名基于输入文件名
                if ($returnCode === 0 && file_exists($expectedOutput)) {
                    if (rename($expectedOutput, $pdfPath)) {
                        $conversionSuccess = true;
                        $conversionLog[] = "使用LibreOffice转换成功";
                    } else {
                        $conversionLog[] = "无法重命名生成的PDF文件";
                    }
                } else {
                    $conversionLog[] = "LibreOffice转换失败";
                }
            }

            // 方案2: 使用unoconv转换
            if (!$conversionSuccess && $this->commandExists('unoconv')) {
                $conversionLog[] = "尝试使用unoconv转换...";

                // 在同一目录下生成输出文件以避免路径问题
                $tempOutputPath = dirname($tempFilePath) . '/output.pdf';

                $command = sprintf(
                    'cd %s && timeout 180 unoconv -f pdf -e "EmbedStandardFonts=true;EmbedFonts=true;ExportNotes=false;UseReferenceXObject=false;ExportFormFields=false;FormsType=0;ReduceImageResolution=false;UseLosslessCompression=true;Quality=100;TextAndLineArt=3" -o %s %s 2>&1',
                    escapeshellarg(dirname($tempFilePath)),
                    escapeshellarg(basename($tempOutputPath)),
                    escapeshellarg(basename($tempFilePath))
                );

                $output = [];
                $returnCode = 0;
                exec($command, $output, $returnCode);

                $conversionLog[] = "unoconv命令: " . $command;
                $conversionLog[] = "返回代码: " . $returnCode;
                $conversionLog[] = "输出: " . implode("\n", $output);

                if ($returnCode === 0 && file_exists($tempOutputPath)) {
                    if (rename($tempOutputPath, $pdfPath)) {
                        $conversionSuccess = true;
                        $conversionLog[] = "使用unoconv转换成功";
                    } else {
                        $conversionLog[] = "无法重命名生成的PDF文件";
                    }
                } else {
                    $conversionLog[] = "unoconv转换失败";
                }
            }

            // 如果上述方法都失败，尝试方案3：使用PDF字体后处理
            if (!$conversionSuccess && $this->commandExists('gs')) {
                $tempOutputPath = $this->tempDir . '/' . uniqid('gs_', true) . '.pdf';

                // 先使用基本的LibreOffice转换
                $basicConversion = $this->basicDocToPdfConversion($tempFilePath);

                if ($basicConversion) {
                    // 使用Ghostscript处理字体嵌入和渲染问题
                    $command = sprintf(
                        'gs -sDEVICE=pdfwrite -dPDFSETTINGS=/prepress -dCompatibilityLevel=1.7 -dNOPAUSE -dQUIET -dBATCH -dSubsetFonts=true -dEmbedAllFonts=true -dPrinted=false -dTextAlphaBits=4 -dGraphicsAlphaBits=4 -dUseCIEColor=true -dUseFastColor=false -dHaveTransparency=true -dLossless=true -dMaxSubsetPct=100 -sOutputFile=%s %s 2>&1',
                        escapeshellarg($tempOutputPath),
                        escapeshellarg($basicConversion)
                    );

                    $output = [];
                    $returnCode = 0;
                    exec($command, $output, $returnCode);

                    if ($returnCode === 0 && file_exists($tempOutputPath)) {
                        if (rename($tempOutputPath, $pdfPath)) {
                            $conversionSuccess = true;
                            unlink($basicConversion); // 删除中间PDF
                        }
                    }
                }
            }
            // 如果两种方法都失败了
            if (!$conversionSuccess) {
                $logDetails = implode("\n", $conversionLog);
                throw new \Exception('无法转换DOC文件，请确保LibreOffice或unoconv已正确安装。');
            }

            return $pdfPath;
        } finally {
            // 清理临时文件
            if (file_exists($tempFilePath)) {
                unlink($tempFilePath);
            }

            // 如果转换失败，清理可能创建的部分PDF文件
            if (!$conversionSuccess && file_exists($pdfPath)) {
                unlink($pdfPath);
            }
        }
    }


    /**
     * 基本的文档到PDF转换（作为后处理的第一步）
     */
    private function basicDocToPdfConversion($filePath)
    {
        $outPath = $this->tempDir . '/' . uniqid('basic_', true) . '.pdf';

        if ($this->commandExists('libreoffice')) {
            $command = sprintf(
                'libreoffice --headless --convert-to "pdf:writer_pdf_Export:EmbedStandardFonts=true;EmbedFonts=true;ExportNotes=false;UseReferenceXObject=false;ExportFormFields=false;FormsType=0;ReduceImageResolution=false;UseLosslessCompression=true;Quality=100;TextAndLineArt=3" --outdir %s %s 2>&1',
                escapeshellarg(dirname($outPath)),
                escapeshellarg($filePath)
            );

            $output = [];
            $returnCode = 0;
            exec($command, $output, $returnCode);

            $generatedPdf = dirname($outPath) . '/' . pathinfo($filePath, PATHINFO_FILENAME) . '.pdf';

            if ($returnCode === 0 && file_exists($generatedPdf)) {
                rename($generatedPdf, $outPath);
                return $outPath;
            }
        }

        return null;
    }



    /**
     * 创建具有ASCII文件名的临时文件副本
     * 
     * @param string $originalFilePath 原始文件路径
     * @return string 临时文件路径
     * @throws \Exception 创建临时文件失败时抛出异常
     */
    private function createAsciiTempFile($originalFilePath)
    {
        $extension = pathinfo($originalFilePath, PATHINFO_EXTENSION);
        $tempFile = tempnam(sys_get_temp_dir(), 'doc_') . '.' . $extension;

        if (!copy($originalFilePath, $tempFile)) {
            throw new \Exception('无法创建文件的临时副本');
        }

        return $tempFile;
    }


    /**
     * 解析页数参数
     */
    private function parsePageNumbers($pages, $totalPages)
    {
        if ($pages === 'all') {
            return range(1, $totalPages);
        }

        if (is_array($pages)) {
            return array_filter($pages, function ($page) use ($totalPages) {
                return $page >= 1 && $page <= $totalPages;
            });
        }

        if (is_string($pages)) {
            $result = [];
            $parts = explode(',', $pages);

            foreach ($parts as $part) {
                $part = trim($part);
                if (strpos($part, '-') !== false) {
                    list($start, $end) = explode('-', $part);
                    $start = max(1, intval($start));
                    $end = min($totalPages, intval($end));
                    $result = array_merge($result, range($start, $end));
                } else {
                    $pageNum = intval($part);
                    if ($pageNum >= 1 && $pageNum <= $totalPages) {
                        $result[] = $pageNum;
                    }
                }
            }

            return array_unique($result);
        }

        return [1];
    }

    /**
     * 获取 PDF 页数
     */
    private function getPdfPageCount($filePath)
    {
        // 尝试使用 Imagick
        if (extension_loaded('imagick')) {
            try {
                $imagick = new \Imagick();
                $imagick->readImage($filePath);
                $pageCount = $imagick->getNumberImages();
                $imagick->clear();
                $imagick->destroy();
                return $pageCount;
            } catch (\Exception $e) {
                // 继续尝试其他方法
            }
        }

        // 使用 pdfinfo
        if ($this->commandExists('pdfinfo')) {
            $command = 'pdfinfo ' . escapeshellarg($filePath);
            $output = shell_exec($command);
            if (preg_match('/Pages:\s*(\d+)/', $output, $matches)) {
                return intval($matches[1]);
            }
        }

        // 使用 Ghostscript
        if ($this->commandExists('gs')) {
            $command = sprintf(
                'gs -dNODISPLAY -dNOSAFER -dBATCH -c "(%s) (r) file runpdfbegin pdfpagecount = quit" 2>/dev/null',
                $filePath
            );
            $output = shell_exec($command);
            // 提取输出中的最后一个非空行，通常是页数
            $lines = array_filter(explode("\n", $output), 'trim');
            $lastLine = end($lines);
            $pageCount = filter_var($lastLine, FILTER_VALIDATE_INT);
            if ($pageCount > 0) {
                return $pageCount;
            }
        }

        return 1; // 默认返回 1 页
    }

    /**
     * 生成文件名
     */
    private function generateFilename($originalPath, $pageNum, $format)
    {
        $basename = pathinfo($originalPath, PATHINFO_FILENAME);
        $timestamp = time();
        return sprintf('%s_page_%d_%s.%s', $basename, $pageNum, $timestamp, $format);
    }

    /**
     * 获取文件 URL
     */
    private function getFileUrl($filename)
    {
        return '/uploads/converted/' . $filename;
    }

    /**
     * 检查命令是否存在
     */
    private function commandExists($command)
    {
        $test = shell_exec("which $command 2>/dev/null");
        return !empty($test);
    }

    /**
     * 获取系统信息
     */
    public function getSystemInfo()
    {
        return [
            'imagick_loaded' => extension_loaded('imagick'),
            'imagick_pdf_support' => extension_loaded('imagick') ? !empty(Imagick::queryFormats("PDF")) : false,
            'ghostscript_available' => $this->commandExists('gs'),
            'poppler_available' => $this->commandExists('pdftoppm'),
            'libreoffice_available' => $this->commandExists('libreoffice'),
            'unoconv_available' => $this->commandExists('unoconv'),
            'pdfinfo_available' => $this->commandExists('pdfinfo'),
        ];
    }
}
