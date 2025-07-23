<?php

namespace app\api\extend;

use Imagick;
use Exception;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory as PhpWordIOFactory;
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
    
    /**
     * 合并文件输出目录
     * @var string
     */
    private string $mergeOutputDir;

    public function __construct($tempDir = null, $outputDir = null, $mergeOutputDir = null)
    {
        $this->tempDir = $tempDir ?: sys_get_temp_dir();   
        $this->outputDir = $outputDir ?:'public/uploads/converted/';
        $this->mergeOutputDir = $mergeOutputDir ?: 'public/uploads/merge/';

        // 确保目录存在
        if (!is_dir($this->outputDir)) {
            error_log("创建输出目录: " . $this->outputDir);
            if (!mkdir($this->outputDir, 0755, true)) {
                error_log("无法创建输出目录: " . $this->outputDir);
            }
        }
        
        // 确保合并文件目录存在
        if (!is_dir($this->mergeOutputDir)) {
            error_log("创建合并文件目录: " . $this->mergeOutputDir);
            if (!mkdir($this->mergeOutputDir, 0755, true)) {
                error_log("无法创建合并文件目录: " . $this->mergeOutputDir);
            }
        }
    }

    /**
     * 转换文档为图片
     */
    public function convertToImages($filePath, $options = [])
    {
        // 检查是否是远程URL（阿里云OSS或其他HTTP/HTTPS链接）
        if (preg_match('/^https?:\/\//', $filePath)) {
            try {
                // 下载远程文件到本地临时目录
                $localFilePath = $this->downloadRemoteFile($filePath);
                
                // 使用本地文件路径进行后续处理
                $result = $this->processLocalFile($localFilePath, $options);
                
                // 处理完成后删除临时文件
                if (file_exists($localFilePath)) {
                    unlink($localFilePath);
                }
                
                return $result;
            } catch (Exception $e) {
                return [
                    'success' => false,
                    'message' => '远程文件处理失败: ' . $e->getMessage(),
                    'data' => []
                ];
            }
        } else {
            // 本地文件处理
            return $this->processLocalFile($filePath, $options);
        }
    }
    
    /**
     * 处理本地文件
     */
    private function processLocalFile($filePath, $options = [])
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
                    throw new Exception("不支持的文件格式: {$fileExt}");
            }
        } catch (Exception $e) {
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
    public function convertPdfToImages($filePath, $options)
    {
        // 方案1: 尝试使用修复后的 Imagick
        try {
            return $this->convertPdfWithImagick($filePath, $options);
        } catch (Exception $e) {
            // 如果 Imagick 失败，尝试其他方案
            error_log("Imagick 转换失败: " . $e->getMessage());
        }

        // 方案2: 使用 Ghostscript
        try {
            return $this->convertPdfWithGhostscript($filePath, $options);
        } catch (Exception $e) {
            error_log("Ghostscript 转换失败: " . $e->getMessage());
        }

        // 方案3: 使用 poppler-utils (pdftoppm)
        try {
            return $this->convertPdfWithPoppler($filePath, $options);
        } catch (Exception $e) {
            error_log("Poppler 转换失败: " . $e->getMessage());
        }

        throw new Exception("所有 PDF 转换方案都失败了");
    }

    /**
     * 使用修复后的 Imagick 转换 PDF
     */
    public function convertPdfWithImagick($filePath, $options)
    {
        if (!extension_loaded('imagick')) {
            throw new Exception('Imagick 扩展未安装');
        }

        // 检查 PDF 支持
        $formats = Imagick::queryFormats("PDF");
        if (empty($formats)) {
            throw new Exception('Imagick 不支持 PDF 格式');
        }

        $imagick = new Imagick();
        try {
            // 设置分辨率
            $imagick->setResolution($options['dpi'], $options['dpi']);
            
            // 设置渲染质量
            $imagick->setImageAlphaChannel(Imagick::ALPHACHANNEL_ACTIVATE);
            $imagick->setImageBackgroundColor('white');
            $imagick->setImageCompressionQuality(100);
            $imagick->setImageCompression(Imagick::COMPRESSION_LOSSLESS);
            
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
                $page->setImageAlphaChannel(Imagick::ALPHACHANNEL_REMOVE);

                // 调整尺寸
                if ($options['width'] || $options['height']) {
                    $page->resizeImage(
                        $options['width'] ?: 0,
                        $options['height'] ?: 0,
                        Imagick::FILTER_LANCZOS,
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
        } catch (Exception $e) {
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
            throw new Exception('Ghostscript 未安装');
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
                throw new Exception("Ghostscript 转换失败: " . implode("\n", $output));
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
            throw new Exception('Poppler-utils 未安装');
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
                throw new Exception("Poppler 转换失败: " . implode("\n", $output));
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
    public function convertDocToImages($filePath, $options)
    {
        // 尝试使用PhpWord库处理DOC/DOCX文件
        if (class_exists('\PhpOffice\PhpWord\PhpWord')) {
            try {
                // 确定文件类型
                $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                
                // 加载文档
                $phpWord = PhpWordIOFactory::load($filePath);
                
                // 先转换为 PDF
                $pdfPath = $this->convertDocToPdf($filePath);
                
                try {
                    $result = $this->convertPdfToImages($pdfPath, $options);
                    
                    // 修改消息显示转换链
                    if ($result['success']) {
                        $result['message'] = '转换成功 (DOC->PDF->图片，使用PhpWord)';
                    }
                    
                    return $result;
                } finally {
                    // 清理临时 PDF 文件
                    if (file_exists($pdfPath)) {
                        unlink($pdfPath);
                    }
                }
            } catch (Exception $e) {
                // 如果PhpWord处理失败，回退到传统方法
                error_log("PhpWord处理DOC/DOCX失败: " . $e->getMessage());
            }
        }
        
        // 传统方法：先转换为 PDF
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






    /**
     * 创建具有ASCII文件名的临时文件副本
     * 
     * @param string $originalFilePath 原始文件路径
     * @return string 临时文件路径
     * @throws Exception 创建临时文件失败时抛出异常
     */
    private function createAsciiTempFile($originalFilePath)
    {
        $extension = pathinfo($originalFilePath, PATHINFO_EXTENSION);
        $tempFile = tempnam(sys_get_temp_dir(), 'doc_') . '.' . $extension;

        if (!copy($originalFilePath, $tempFile)) {
            throw new Exception('无法创建文件的临时副本');
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
     * 
     * @param string $filePath PDF文件路径
     * @return int 页数
     */
    public function getPdfPageCount($filePath)
    {
        // 尝试使用 Imagick
        if (extension_loaded('imagick')) {
            try {
                $imagick = new Imagick();
                $imagick->readImage($filePath);
                
                $pageCount = $imagick->getNumberImages();
                $imagick->clear();
                $imagick->destroy();
                return $pageCount;
            } catch (Exception $e) {
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
     * 获取DOC文件页数
     * 
     * @param string $filePath DOC文件路径
     * @return int 页数
     */
    public function getDocPageCount($filePath)
    {
    
        try {
            // 先转换为PDF
            $pdfPath = $this->convertDocToPdf($filePath);
            
            // 获取PDF的页数
            $pageCount = $this->getPdfPageCount($pdfPath);
            
            // 删除临时PDF文件
            if (file_exists($pdfPath)) {
                unlink($pdfPath);
            }
            
            return $pageCount;
        } catch (Exception $e) {
            error_log("获取DOC页数失败: " . $e->getMessage());
            return 1; // 默认返回1页
        }
    }
    
    /**
     * 获取DOCX文件页数
     * 
     * @param string $filePath DOCX文件路径
     * @return int 页数
     */
    public function getDocxPageCount($filePath)
    {

        // 方法1：使用ZipArchive读取文档内容
        if (class_exists('ZipArchive')) {
            try {
                $zip = new \ZipArchive();
                if ($zip->open($filePath) === true) {
                    // 尝试读取app.xml文件，它包含页数信息
                    $content = $zip->getFromName('docProps/app.xml');
                    $zip->close();
                    
                    if ($content) {
                        // 解析XML内容
                        $xml = simplexml_load_string($content);
                        if ($xml && isset($xml->Pages)) {
                            return (int)$xml->Pages;
                        }
                    }
                }
            } catch (Exception $e) {
                // 继续尝试其他方法
            }
        }
        
        // 方法2：转换为PDF后获取页数
        try {
            // 先转换为PDF
            $pdfPath = $this->convertDocToPdf($filePath);
            
            // 获取PDF的页数
            $pageCount = $this->getPdfPageCount($pdfPath);
            
            // 删除临时PDF文件
            if (file_exists($pdfPath)) {
                unlink($pdfPath);
            }
            
            return $pageCount;
        } catch (Exception $e) {
            error_log("获取DOCX页数失败: " . $e->getMessage());
            return 1; // 默认返回1页
        }
    }
    
    /**
     * 获取文档页数（自动识别文件类型）
     * 
     * @param string $filePath 文件路径
     * @return int 页数
     */
    public function getDocumentPageCount($filePath)
    {
        $fileExt = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        
        switch ($fileExt) {
            case 'pdf':
                return $this->getPdfPageCount($filePath);
            case 'doc':
                return $this->getDocPageCount($filePath);
            case 'docx':
                return $this->getDocxPageCount($filePath);
            default:
                throw new Exception("不支持的文件格式: {$fileExt}");
        }
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
            'phpword_available' => class_exists('\PhpOffice\PhpWord\PhpWord'),
        ];
    }
    
    /**
     * 合并PDF文件
     * 
     * @param array $files 要合并的PDF文件路径数组
     * @param string $outputPath 输出文件路径，如果为null则自动生成
     * @return string 合并后的PDF文件路径
     * @throws Exception 合并失败时抛出异常
     */
    public function mergePdfFiles(array $files, $outputPath = null)
    {
        // 验证文件列表
        if (empty($files)) {
            throw new Exception('没有提供要合并的文件');
        }
        
        // 验证所有文件都是PDF
        foreach ($files as $file) {
            if (!file_exists($file)) {
                throw new Exception('文件不存在: ' . $file);
            }
            
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if ($ext !== 'pdf') {
                throw new Exception('只能合并PDF文件，发现非PDF文件: ' . $file);
            }
        }
        
        // 如果未提供输出路径，则自动生成
        if ($outputPath === null) {
            // 确保目录存在并可写
            if (!is_dir($this->mergeOutputDir)) {
                mkdir($this->mergeOutputDir, 0755, true);
            }
            
            // 使用绝对路径
            $outputPath = dirname($this->mergeOutputDir) . '/' . basename($this->mergeOutputDir) . '/' . uniqid('merged_', true) . '.pdf';
            
            // 记录输出路径
            error_log("PDF合并输出路径: " . $outputPath);
        }
        
        // 记录要合并的文件
        error_log("要合并的PDF文件列表: " . implode(", ", $files));
        
        // 尝试使用Ghostscript合并
        if ($this->commandExists('gs')) {
            error_log("使用Ghostscript合并PDF文件");
            $fileArgs = implode(' ', array_map('escapeshellarg', $files));
            $command = sprintf(
                'gs -dBATCH -dNOPAUSE -q -sDEVICE=pdfwrite -dPDFSETTINGS=/prepress -dCompatibilityLevel=1.7 -dAutoRotatePages=/None -dEmbedAllFonts=true -dSubsetFonts=true -dCompressFonts=true -dNOPLATFONTS -dMaxSubsetPct=100 -dPDFA=2 -sOutputFile=%s %s 2>&1',
                escapeshellarg($outputPath),
                $fileArgs
            );
            
            error_log("执行命令: " . $command);
            
            $output = [];
            $returnCode = 0;
            exec($command, $output, $returnCode);
            
            error_log("Ghostscript返回代码: " . $returnCode);
            
            if ($returnCode === 0 && file_exists($outputPath) && filesize($outputPath) > 0) {
                error_log("Ghostscript合并成功，文件大小: " . filesize($outputPath));
                return $outputPath;
            }
            
            // 如果失败，记录错误
            $errorMsg = implode("\n", $output);
            error_log("Ghostscript合并PDF失败: " . $errorMsg);
        }
        
        // 尝试使用pdftk合并
        if ($this->commandExists('pdftk')) {
            $fileArgs = implode(' ', array_map('escapeshellarg', $files));
            $command = sprintf(
                'pdftk %s cat output %s 2>&1',
                $fileArgs,
                escapeshellarg($outputPath)
            );
            
            $output = [];
            $returnCode = 0;
            exec($command, $output, $returnCode);
            
            if ($returnCode === 0 && file_exists($outputPath) && filesize($outputPath) > 0) {
                return $outputPath;
            }
            
            // 如果失败，记录错误
            $errorMsg = implode("\n", $output);
            error_log("pdftk合并PDF失败: " . $errorMsg);
        }
        
        // 尝试使用PdfMerger库合并PDF
        if (class_exists('\Jurosh\PDFMerge\PDFMerger')) {
            error_log("尝试使用PdfMerger库合并PDF文件");
            try {
                $merger = new \Jurosh\PDFMerge\PDFMerger();
                
                // 添加所有PDF文件
                foreach ($files as $file) {
                    error_log("添加文件到PdfMerger: {$file}");
                    $merger->addPDF($file, 'all');
                }
                
                // 合并并保存
                error_log("合并并保存PDF到: {$outputPath}");
                $merger->merge('file', $outputPath);
                
                // 检查输出文件
                if (file_exists($outputPath) && filesize($outputPath) > 0) {
                    error_log("PdfMerger合并成功，文件大小: " . filesize($outputPath));
                    return $outputPath;
                } else {
                    error_log("PdfMerger合并失败，文件不存在或为空");
                }
            } catch (\Exception $e) {
                error_log("PdfMerger合并失败: " . $e->getMessage());
            }
        } else {
            error_log("PdfMerger库不可用");
        }
        
        // 如果外部工具和PdfMerger都失败了，尝试使用FPDI
        try {
            error_log("尝试使用FPDI合并PDF文件");
            
            // 使用临时文件
            $tempOutputPath = $this->tempDir . '/' . uniqid('temp_merged_', true) . '.pdf';
            error_log("FPDI临时输出路径: " . $tempOutputPath);
            
            // 检查FPDI库是否可用
            if (!class_exists('\setasign\Fpdi\Fpdi')) {
                error_log("缺少FPDI库支持");
                throw new Exception('无法合并PDF文件：缺少FPDI库支持');
            }
            
            // 检查TCPDF库是否可用
            if (class_exists('\TCPDF')) {
                error_log("使用TCPDF+FPDI合并PDF");
                try {
                    // 使用TCPDF作为基础的FPDI
                    $pdf = new \setasign\Fpdi\Tcpdf\Fpdi();
                    error_log("TCPDF+FPDI实例创建成功");
                } catch (\Exception $e) {
                    error_log("创建TCPDF+FPDI实例失败: " . $e->getMessage());
                    throw new Exception('创建TCPDF+FPDI实例失败: ' . $e->getMessage());
                }
            } else {
                error_log("使用标准FPDI合并PDF");
                try {
                    $pdf = new \setasign\Fpdi\Fpdi();
                    error_log("FPDI实例创建成功");
                } catch (\Exception $e) {
                    error_log("创建FPDI实例失败: " . $e->getMessage());
                    throw new Exception('创建FPDI实例失败: ' . $e->getMessage());
                }
            }
            
            // 设置PDF文档属性
            $pdf->SetCreator('YunPrint');
            $pdf->SetAuthor('YunPrint');
            $pdf->SetTitle('Merged PDF Document');
            $pdf->SetSubject('PDF Merge');
            $pdf->SetKeywords('PDF, merge');
            
            // 禁用自动页面断开
            $pdf->SetAutoPageBreak(false);
            
            // 循环处理每个PDF文件
            foreach ($files as $fileIndex => $file) {
                error_log("处理PDF文件 {$fileIndex}: {$file}");
                
                // 检查文件是否存在且可读
                if (!file_exists($file)) {
                    error_log("文件不存在: {$file}");
                    throw new Exception("文件不存在: {$file}");
                }
                
                if (!is_readable($file)) {
                    error_log("文件不可读: {$file}");
                    throw new Exception("文件不可读: {$file}");
                }
                
                // 检查文件大小
                $fileSize = filesize($file);
                error_log("文件大小: {$fileSize} 字节");
                
                if ($fileSize <= 0) {
                    error_log("文件为空: {$file}");
                    throw new Exception("文件为空: {$file}");
                }
                
                // 检查文件内容
                $fileContent = file_get_contents($file);
                if ($fileContent === false) {
                    error_log("无法读取文件内容: {$file}");
                    throw new Exception("无法读取文件内容: {$file}");
                }
                
                error_log("文件内容前100字节: " . bin2hex(substr($fileContent, 0, 100)));
                
                // 检查PDF文件头
                if (substr($fileContent, 0, 4) !== '%PDF') {
                    error_log("文件不是有效的PDF格式: {$file}");
                    throw new Exception("文件不是有效的PDF格式: {$file}");
                }
                
                try {
                    // 获取页数
                    error_log("尝试设置源文件: {$file}");
                    try {
                        $pageCount = $pdf->setSourceFile($file);
                        error_log("文件 {$file} 包含 {$pageCount} 页");
                    } catch (\Exception $e) {
                        error_log("设置源文件失败: " . $e->getMessage());
                        throw new Exception("设置源文件失败: " . $e->getMessage());
                    }
                    
                    // 导入所有页面
                    for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                        error_log("导入第 {$pageNo} 页");
                        
                        // 导入页面
                        try {
                            $templateId = $pdf->importPage($pageNo);
                            error_log("成功导入第 {$pageNo} 页，模板ID: {$templateId}");
                        } catch (\Exception $e) {
                            error_log("导入第 {$pageNo} 页失败: " . $e->getMessage());
                            throw new Exception("导入第 {$pageNo} 页失败: " . $e->getMessage());
                        }
                        
                        // 获取导入页面的尺寸
                        try {
                            $size = $pdf->getTemplateSize($templateId);
                            error_log("页面尺寸: 宽度={$size['width']}, 高度={$size['height']}, 方向={$size['orientation']}");
                            
                            // 确保尺寸有效
                            if ($size['width'] <= 0 || $size['height'] <= 0) {
                                error_log("页面尺寸无效，使用默认尺寸");
                                $size['width'] = 210;
                                $size['height'] = 297;
                                $size['orientation'] = 'P';
                            }
                        } catch (\Exception $e) {
                            error_log("获取模板尺寸失败: " . $e->getMessage());
                            error_log("使用默认尺寸");
                            $size['width'] = 210;
                            $size['height'] = 297;
                            $size['orientation'] = 'P';
                        }
                        
                        // 添加新页面（使用导入页面的尺寸）
                        try {
                            // 确定页面方向
                            $orientation = ($size['width'] > $size['height']) ? 'L' : 'P';
                            
                            // 添加页面
                            $pdf->AddPage($orientation, [$size['width'], $size['height']]);
                            error_log("成功添加新页面，方向: {$orientation}");
                        } catch (\Exception $e) {
                            error_log("添加新页面失败: " . $e->getMessage());
                            error_log("尝试使用默认页面设置");
                            try {
                                $pdf->AddPage();
                                error_log("使用默认设置添加页面成功");
                            } catch (\Exception $e2) {
                                error_log("使用默认设置添加页面也失败: " . $e2->getMessage());
                                throw new Exception("添加新页面失败: " . $e->getMessage());
                            }
                        }
                        
                        // 使用导入的页面
                        try {
                            // 计算缩放比例，确保页面内容适合页面大小
                            $pdf->useTemplate($templateId, 0, 0, null, null, true);
                            error_log("成功使用模板 {$templateId}");
                        } catch (\Exception $e) {
                            error_log("使用模板失败: " . $e->getMessage());
                            error_log("尝试使用替代方法");
                            try {
                                // 尝试使用替代方法
                                $pdf->useImportedPage($templateId, 0, 0, null, null);
                                error_log("使用替代方法成功");
                            } catch (\Exception $e2) {
                                error_log("使用替代方法也失败: " . $e2->getMessage());
                                throw new Exception("使用模板失败: " . $e->getMessage());
                            }
                        }
                    }
                } catch (Exception $pageException) {
                    error_log("处理文件 {$file} 页面时出错: " . $pageException->getMessage());
                    throw $pageException;
                }
            }
            
            error_log("生成合并后的PDF文件到: {$tempOutputPath}");
            // 输出合并后的PDF
            try {
                // 确保输出目录存在
                $tempOutputDir = dirname($tempOutputPath);
                if (!is_dir($tempOutputDir)) {
                    error_log("创建临时输出目录: {$tempOutputDir}");
                    if (!mkdir($tempOutputDir, 0755, true)) {
                        error_log("无法创建临时输出目录: {$tempOutputDir}");
                        throw new Exception("无法创建临时输出目录: {$tempOutputDir}");
                    }
                }
                
                // 检查目录是否可写
                if (!is_writable($tempOutputDir)) {
                    error_log("临时输出目录不可写: {$tempOutputDir}");
                    throw new Exception("临时输出目录不可写: {$tempOutputDir}");
                }
                
                // 输出PDF文件
                error_log("调用FPDI Output方法");
                try {
                    // 尝试使用不同的输出方式
                    if (method_exists($pdf, 'Output')) {
                        // 标准FPDI/TCPDF输出
                        error_log("使用标准Output方法");
                        $pdf->Output($tempOutputPath, 'F');
                    } else if (method_exists($pdf, 'output')) {
                        // 小写的output方法
                        error_log("使用小写output方法");
                        file_put_contents($tempOutputPath, $pdf->output());
                    } else {
                        // 尝试直接保存
                        error_log("尝试直接保存PDF");
                        $pdfContent = $pdf->Output('', 'S'); // 获取PDF内容为字符串
                        if (!file_put_contents($tempOutputPath, $pdfContent)) {
                            throw new Exception("无法写入PDF文件");
                        }
                    }
                    error_log("FPDI Output方法执行完成");
                } catch (\Exception $e) {
                    error_log("FPDI Output方法失败: " . $e->getMessage());
                    
                    // 尝试备用方法
                    error_log("尝试备用输出方法");
                    try {
                        $pdfContent = $pdf->Output('', 'S'); // 获取PDF内容为字符串
                        if (!file_put_contents($tempOutputPath, $pdfContent)) {
                            throw new Exception("无法写入PDF文件");
                        }
                        error_log("备用输出方法成功");
                    } catch (\Exception $e2) {
                        error_log("备用输出方法也失败: " . $e2->getMessage());
                        throw new Exception("无法输出PDF文件: " . $e->getMessage());
                    }
                }
            } catch (\Exception $e) {
                error_log("生成PDF文件失败: " . $e->getMessage());
                throw new Exception("生成PDF文件失败: " . $e->getMessage());
            }
            
            // 检查输出文件
            if (file_exists($tempOutputPath)) {
                $mergedFileSize = filesize($tempOutputPath);
                error_log("临时合并文件大小: {$mergedFileSize} 字节");
                
                // 检查文件内容
                $fileContent = file_get_contents($tempOutputPath);
                if ($fileContent === false) {
                    error_log("无法读取临时文件内容");
                    throw new Exception("无法读取临时文件内容");
                }
                
                error_log("临时文件内容前100字节: " . bin2hex(substr($fileContent, 0, 100)));
                
                if ($mergedFileSize > 0) {
                    // 确保输出目录存在
                    $outputDir = dirname($outputPath);
                    if (!is_dir($outputDir)) {
                        error_log("创建最终输出目录: {$outputDir}");
                        if (!mkdir($outputDir, 0755, true)) {
                            error_log("无法创建最终输出目录: {$outputDir}");
                            throw new Exception("无法创建最终输出目录: {$outputDir}");
                        }
                    }
                    
                    // 检查目录是否可写
                    if (!is_writable($outputDir)) {
                        error_log("最终输出目录不可写: {$outputDir}");
                        throw new Exception("最终输出目录不可写: {$outputDir}");
                    }
                    
                    // 移动到最终位置
                    error_log("移动临时文件到最终位置: {$outputPath}");
                    if (rename($tempOutputPath, $outputPath)) {
                        error_log("文件移动成功");
                        
                        // 最终检查
                        if (file_exists($outputPath) && filesize($outputPath) > 0) {
                            error_log("最终文件检查成功，大小: " . filesize($outputPath) . " 字节");
                            return $outputPath;
                        } else {
                            error_log("最终文件检查失败，文件存在: " . (file_exists($outputPath) ? 'true' : 'false') . 
                                      ", 文件大小: " . (file_exists($outputPath) ? filesize($outputPath) : 0));
                            throw new Exception("最终文件检查失败");
                        }
                    } else {
                        error_log("无法移动文件: {$tempOutputPath} -> {$outputPath}");
                        throw new Exception("无法移动合并后的PDF文件");
                    }
                } else {
                    error_log("生成的PDF文件为空");
                    throw new Exception("生成的PDF文件为空");
                }
            } else {
                error_log("未能生成PDF文件");
                throw new Exception("未能生成PDF文件");
            }
            
            throw new Exception('无法生成合并的PDF文件');
        } catch (Exception $e) {
            // 如果PHP方法也失败了，抛出最终异常
            throw new Exception('无法合并PDF文件: ' . $e->getMessage());
        }
    }
    
    /**
     * 使用简单的文件拼接方式合并PDF文件
     * 这是一个备用方法，当其他方法都失败时使用
     * 
     * @param array $files 要合并的PDF文件路径数组
     * @param string $outputPath 输出文件路径
     * @return string 合并后的PDF文件路径
     * @throws Exception 合并失败时抛出异常
     */
    private function simplePdfMerge(array $files, $outputPath)
    {
        error_log("尝试使用简单文件拼接方式合并PDF");
        
        // 创建临时目录
        $tempDir = $this->tempDir . '/' . uniqid('pdf_merge_', true);
        if (!mkdir($tempDir, 0755, true)) {
            error_log("无法创建临时目录: {$tempDir}");
            throw new Exception("无法创建临时目录");
        }
        
        try {
            // 创建一个ZIP文件来存储所有PDF
            $zipPath = $tempDir . '/merged.zip';
            $zip = new \ZipArchive();
            
            if ($zip->open($zipPath, \ZipArchive::CREATE) !== true) {
                error_log("无法创建ZIP文件");
                throw new Exception("无法创建ZIP文件");
            }
            
            // 添加所有PDF文件到ZIP
            foreach ($files as $index => $file) {
                $filename = "page_{$index}.pdf";
                error_log("添加文件到ZIP: {$file} 作为 {$filename}");
                $zip->addFile($file, $filename);
            }
            
            // 关闭ZIP文件
            $zip->close();
            
            // 重命名ZIP为PDF
            if (!copy($zipPath, $outputPath)) {
                error_log("无法复制ZIP文件到输出路径");
                throw new Exception("无法复制ZIP文件到输出路径");
            }
            
            // 检查输出文件
            if (file_exists($outputPath) && filesize($outputPath) > 0) {
                error_log("简单合并成功，文件大小: " . filesize($outputPath));
                return $outputPath;
            } else {
                error_log("简单合并失败，文件不存在或为空");
                throw new Exception("简单合并失败，文件不存在或为空");
            }
        } catch (\Exception $e) {
            error_log("简单合并失败: " . $e->getMessage());
            throw $e;
        } finally {
            // 清理临时文件
            if (file_exists($zipPath)) {
                unlink($zipPath);
            }
            if (is_dir($tempDir)) {
                rmdir($tempDir);
            }
        }
    }
    

 
    
}
