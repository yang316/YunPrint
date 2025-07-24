<?php

namespace app\api\extend;

use Imagick;
use Exception;
use ZipArchive;

/**
 * PDF处理类
 * 提供PDF文件的预览图生成、页数读取和合并功能
 */
class PdfProcessor
{
    /**
     * 临时文件目录
     * @var string
     */
    private string $tempDir;

    /**
     * 输出文件目录
     * @var string
     */
    private string $outputDir;

    /**
     * 合并文件输出目录
     * @var string
     */
    private string $mergeOutputDir;

    /**
     * 构造函数
     * 
     * @param string|null $tempDir 临时文件目录
     * @param string|null $outputDir 输出文件目录
     * @param string|null $mergeOutputDir 合并文件输出目录
     */
    public function __construct($tempDir = null, $outputDir = null, $mergeOutputDir = null)
    {
        // 设置临时目录
        $this->tempDir = $tempDir ?? dirname(__DIR__, 3) . '/public/uploads/temp';
        if (!is_dir($this->tempDir)) {
            mkdir($this->tempDir, 0755, true);
        }

        // 设置输出目录
        $this->outputDir = $outputDir ?? dirname(__DIR__, 3) . '/public/uploads/images';
        if (!is_dir($this->outputDir)) {
            mkdir($this->outputDir, 0755, true);
        }

        // 设置合并输出目录
        $this->mergeOutputDir = $mergeOutputDir ?? dirname(__DIR__, 3) . '/public/uploads/merge';
        if (!is_dir($this->mergeOutputDir)) {
            mkdir($this->mergeOutputDir, 0755, true);
        }
    }

    /**
     * 生成PDF文件的预览图
     * 
     * @param string $pdfPath PDF文件路径
     * @param array|string $pages 要生成预览图的页码，可以是数组、范围字符串或'all'
     * @param int $resolution 分辨率
     * @param string $format 输出图片格式
     * @param int $quality 图片质量
     * @return array 生成的预览图路径数组
     * @throws Exception 处理失败时抛出异常
     */
    public function generatePreviewImages($pdfPath, $pages = 'all', $resolution = 150, $format = 'jpg', $quality = 90)
    {
        // 验证文件存在
        if (!file_exists($pdfPath)) {
            throw new Exception('PDF文件不存在: ' . $pdfPath);
        }

        // 获取文件扩展名
        $ext = strtolower(pathinfo($pdfPath, PATHINFO_EXTENSION));
        if ($ext !== 'pdf') {
            throw new Exception('不是有效的PDF文件: ' . $pdfPath);
        }

        // 获取总页数
        $totalPages = $this->getPageCount($pdfPath);
        if ($totalPages <= 0) {
            throw new Exception('无法获取PDF页数或PDF文件为空');
        }

        // 解析页码
        $pageNumbers = $this->parsePageNumbers($pages, $totalPages);
        if (empty($pageNumbers)) {
            throw new Exception('没有有效的页码可以处理');
        }

        // 尝试使用Imagick转换
        // if (extension_loaded('imagick')) {
        //     return $this->convertWithImagick($pdfPath, $pageNumbers, $resolution, $format, $quality);
        // }

        // 尝试使用Ghostscript转换
        if ($this->commandExists('gs')) {
            return $this->convertWithGhostscript($pdfPath, $pageNumbers, $resolution, $format, $quality);
        }

        // 尝试使用Poppler-utils转换
        if ($this->commandExists('pdftoppm')) {
            return $this->convertWithPoppler($pdfPath, $pageNumbers, $resolution, $format, $quality);
        }

        throw new Exception('无法转换PDF文件：系统缺少必要的转换工具');
    }

    /**
     * 使用Imagick转换PDF为图片
     * 
     * @param string $pdfPath PDF文件路径
     * @param array $pageNumbers 页码数组
     * @param int $resolution 分辨率
     * @param string $format 输出图片格式
     * @param int $quality 图片质量
     * @return array 生成的图片路径数组
     * @throws Exception 处理失败时抛出异常
     */
    private function convertWithImagick($pdfPath, $pageNumbers, $resolution, $format, $quality)
    {
        try {
            $imagick = new Imagick();
            $imagick->setResolution($resolution, $resolution);

            // 设置读取选项
            $imagick->setOption('pdf:use-cropbox', 'true');

            // 读取PDF文件
            $imagick->readImage($pdfPath);

            $outputFiles = [];

            // 处理每一页
            foreach ($pageNumbers as $pageNumber) {
                // 设置当前页
                $imagick->setIteratorIndex($pageNumber - 1);

                // 获取当前页的Imagick对象
                $currentPage = $imagick->getImage();

                // 设置图片格式和质量
                $currentPage->setImageFormat($format);
                $currentPage->setImageCompressionQuality($quality);

                // 生成输出文件名
                $outputFilename = $this->generateFilename($pdfPath, $pageNumber, $format);
                $outputPath = $this->outputDir . '/' . $outputFilename;

                // 保存图片
                $currentPage->writeImage($outputPath);
                $currentPage->clear();

                $outputFiles[] = $outputPath;
            }

            $imagick->clear();
            return $outputFiles;
        } catch (Exception $e) {
            throw new Exception('Imagick转换PDF失败: ' . $e->getMessage());
        }
    }

    /**
     * 使用Ghostscript转换PDF为图片
     * 
     * @param string $pdfPath PDF文件路径
     * @param array $pageNumbers 页码数组
     * @param int $resolution 分辨率
     * @param string $format 输出图片格式
     * @param int $quality 图片质量
     * @return array 生成的图片路径数组
     * @throws Exception 处理失败时抛出异常
     */
    private function convertWithGhostscript($pdfPath, $pageNumbers, $resolution, $format, $quality)
    {
        $outputFiles = [];

        // 创建临时目录
        $tempOutputDir = $this->tempDir . '/' . uniqid('gs_output_', true);
        if (!mkdir($tempOutputDir, 0755, true)) {
            throw new Exception('无法创建临时输出目录');
        }

        try {
            // 处理每一页
            foreach ($pageNumbers as $pageNumber) {
                // 生成输出文件名
                $outputFilename = $this->generateFilename($pdfPath, $pageNumber, $format);
                $outputPath = $this->outputDir . '/' . $outputFilename;

                // 构建Ghostscript命令
                $gsFormat = ($format === 'jpg') ? 'jpeg' : $format;
                $qualityOption = ($format === 'jpg' || $format === 'jpeg') ? "-dJPEGQ={$quality}" : '';
                
                // 设置正确的Ghostscript设备名称
                $deviceName = '';
                switch ($format) {
                    case 'jpg':
                    case 'jpeg':
                        $deviceName = 'jpeg';
                        break;
                    case 'png':
                        $deviceName = 'png16m';
                        break;
                    case 'tiff':
                        $deviceName = 'tiff24nc';
                        break;
                    default:
                        $deviceName = 'jpeg';
                        break;
                }

                $command = sprintf(
                    'gs -dSAFER -dBATCH -dNOPAUSE -sDEVICE=%s %s -r%d -dFirstPage=%d -dLastPage=%d -sOutputFile=%s %s 2>&1',
                    $deviceName,
                    $qualityOption,
                    $resolution,
                    $pageNumber,
                    $pageNumber,
                    escapeshellarg($outputPath),
                    escapeshellarg($pdfPath)
                );

                // 执行命令
                $output = [];
                $returnCode = 0;
                exec($command, $output, $returnCode);

                if ($returnCode !== 0) {
                    throw new Exception('Ghostscript转换失败: ' . implode("\n", $output));
                }

                if (!file_exists($outputPath)) {
                    throw new Exception('Ghostscript未能生成输出文件');
                }

                $outputFiles[] = $outputPath;
            }

            return $outputFiles;
        } finally {
            // 清理临时目录
            if (is_dir($tempOutputDir)) {
                $this->removeDirectory($tempOutputDir);
            }
        }
    }

    /**
     * 使用Poppler-utils转换PDF为图片
     * 
     * @param string $pdfPath PDF文件路径
     * @param array $pageNumbers 页码数组
     * @param int $resolution 分辨率
     * @param string $format 输出图片格式
     * @param int $quality 图片质量
     * @return array 生成的图片路径数组
     * @throws Exception 处理失败时抛出异常
     */
    private function convertWithPoppler($pdfPath, $pageNumbers, $resolution, $format, $quality)
    {
        $outputFiles = [];

        // 创建临时目录
        $tempOutputDir = $this->tempDir . '/' . uniqid('poppler_output_', true);
        if (!mkdir($tempOutputDir, 0755, true)) {
            throw new Exception('无法创建临时输出目录');
        }

        try {
            // 处理每一页
            foreach ($pageNumbers as $pageNumber) {
                // 生成临时输出文件前缀
                $tempOutputPrefix = $tempOutputDir . '/page';

                // 构建pdftoppm命令
                $formatOption = '';
                if ($format === 'jpg' || $format === 'jpeg') {
                    $formatOption = '-jpeg -jpegopt quality=' . $quality;
                } elseif ($format === 'png') {
                    $formatOption = '-png';
                } elseif ($format === 'tiff') {
                    $formatOption = '-tiff';
                }

                $command = sprintf(
                    'pdftoppm %s -r %d -f %d -l %d %s %s 2>&1',
                    $formatOption,
                    $resolution,
                    $pageNumber,
                    $pageNumber,
                    escapeshellarg($pdfPath),
                    escapeshellarg($tempOutputPrefix)
                );

                // 执行命令
                $output = [];
                $returnCode = 0;
                exec($command, $output, $returnCode);

                if ($returnCode !== 0) {
                    throw new Exception('Poppler转换失败: ' . implode("\n", $output));
                }

                // 查找生成的文件
                $generatedFiles = glob($tempOutputDir . '/*');
                if (empty($generatedFiles)) {
                    throw new Exception('Poppler未能生成输出文件');
                }

                // 生成最终输出文件名
                $outputFilename = $this->generateFilename($pdfPath, $pageNumber, $format);
                $outputPath = $this->outputDir . '/' . $outputFilename;

                // 移动生成的文件到输出目录
                if (!copy($generatedFiles[0], $outputPath)) {
                    throw new Exception('无法复制生成的图片到输出目录');
                }

                $outputFiles[] = $outputPath;
            }

            return $outputFiles;
        } finally {
            // 清理临时目录
            if (is_dir($tempOutputDir)) {
                $this->removeDirectory($tempOutputDir);
            }
        }
    }

    /**
     * 获取PDF文件的页数
     * 
     * @param string $pdfPath PDF文件路径
     * @return int 页数
     * @throws Exception 处理失败时抛出异常
     */
    public function getPageCount($pdfPath)
    {
        // 验证文件存在
        if (!file_exists($pdfPath)) {
            throw new Exception('PDF文件不存在: ' . $pdfPath);
        }

        // 尝试使用Imagick获取页数
        if (extension_loaded('imagick')) {
            try {
                $imagick = new Imagick($pdfPath);
                $pageCount = $imagick->getNumberImages();
                $imagick->clear();

                if ($pageCount > 0) {
                    return $pageCount;
                }
            } catch (Exception $e) {
                // 继续尝试其他方法
            }
        }

        // 尝试使用pdfinfo获取页数
        if ($this->commandExists('pdfinfo')) {
            $command = 'pdfinfo ' . escapeshellarg($pdfPath) . ' 2>&1';
            $output = [];
            exec($command, $output);

            foreach ($output as $line) {
                if (preg_match('/Pages:\s*(\d+)/i', $line, $matches)) {
                    return (int)$matches[1];
                }
            }
        }

        // 尝试使用Ghostscript获取页数
        if ($this->commandExists('gs')) {
            $command = sprintf(
                'gs -dNODISPLAY -dNOSAFER -dBATCH -c "(%s) (r) file runpdfbegin pdfpagecount = quit" 2>/dev/null',
                $pdfPath
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

        throw new Exception('无法获取PDF页数');
    }

    /**
     * 合并多个PDF文件
     * 
     * @param array $files 要合并的PDF文件路径数组
     * @param string|null $outputPath 输出文件路径，如果为null则自动生成
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
                if (!mkdir($this->mergeOutputDir, 0755, true)) {
                    throw new Exception('无法创建输出目录: ' . $this->mergeOutputDir);
                }
            }
            
            if (!is_writable($this->mergeOutputDir)) {
                throw new Exception('输出目录不可写: ' . $this->mergeOutputDir);
            }

            // 使用绝对路径
            $outputPath = $this->mergeOutputDir . '/' . uniqid('merged_', true) . '.pdf';
        } else {
            // 检查输出路径的目录是否存在且可写
            $outputDir = dirname($outputPath);
            if (!is_dir($outputDir)) {
                if (!mkdir($outputDir, 0755, true)) {
                    throw new Exception('无法创建输出目录: ' . $outputDir);
                }
            }
            
            if (!is_writable($outputDir)) {
                throw new Exception('输出目录不可写: ' . $outputDir);
            }
        }

        // 使用Ghostscript合并
        if (!$this->commandExists('gs')) {
            throw new Exception('系统中未安装Ghostscript，无法合并PDF文件');
        }

        // 尝试使用Ghostscript合并
        $fileArgs = implode(' ', array_map('escapeshellarg', $files));
        $command = sprintf(
            'gs -dBATCH -dNOPAUSE -q -sDEVICE=pdfwrite -sOutputFile=%s %s 2>&1',
            escapeshellarg($outputPath),
            $fileArgs
        );
        
        error_log("执行命令: " . $command);
        
        $output = [];
        $returnCode = 0;
        exec($command, $output, $returnCode);
        
        error_log("Ghostscript返回代码: " . $returnCode);
        error_log("Ghostscript输出: " . implode("\n", $output));
        error_log("输出文件是否存在: " . (file_exists($outputPath) ? '是' : '否'));
        if (file_exists($outputPath)) {
            error_log("输出文件大小: " . filesize($outputPath) . " 字节");
        }
        
        if ($returnCode === 0 && file_exists($outputPath) && filesize($outputPath) > 0) {
            error_log("Ghostscript合并成功，文件大小: " . filesize($outputPath));
            return $outputPath;
        }
        
        // 如果失败，记录错误并抛出异常
        $errorMsg = implode("\n", $output);
        $detailedError = sprintf(
            'PDF合并失败 - 返回代码: %d, 输出文件存在: %s, 文件大小: %d, 错误信息: %s',
            $returnCode,
            file_exists($outputPath) ? '是' : '否',
            file_exists($outputPath) ? filesize($outputPath) : 0,
            $errorMsg
        );
        throw new Exception($detailedError);
    }



    /**
     * 解析页码
     * 
     * @param array|string $pages 页码，可以是数组、范围字符串或'all'
     * @param int $totalPages 总页数
     * @return array 有效的页码数组
     */
    private function parsePageNumbers($pages, $totalPages)
    {
        $pageNumbers = [];

        // 如果是'all'，则返回所有页码
        if ($pages === 'all') {
            for ($i = 1; $i <= $totalPages; $i++) {
                $pageNumbers[] = $i;
            }
            return $pageNumbers;
        }

        // 如果是数组，则直接使用
        if (is_array($pages)) {
            foreach ($pages as $page) {
                $page = (int)$page;
                if ($page >= 1 && $page <= $totalPages) {
                    $pageNumbers[] = $page;
                }
            }
            return $pageNumbers;
        }

        // 如果是字符串，则解析范围
        if (is_string($pages)) {
            // 支持逗号分隔的多个范围，如 "1-3,5,7-9"
            $ranges = explode(',', $pages);
            foreach ($ranges as $range) {
                $range = trim($range);

                // 单个页码
                if (is_numeric($range)) {
                    $page = (int)$range;
                    if ($page >= 1 && $page <= $totalPages) {
                        $pageNumbers[] = $page;
                    }
                    continue;
                }

                // 范围，如 "1-5"
                if (preg_match('/^(\d+)-(\d+)$/', $range, $matches)) {
                    $start = (int)$matches[1];
                    $end = (int)$matches[2];

                    // 确保范围有效
                    if ($start > $end) {
                        list($start, $end) = [$end, $start];
                    }

                    // 限制在有效范围内
                    $start = max(1, $start);
                    $end = min($totalPages, $end);

                    for ($i = $start; $i <= $end; $i++) {
                        $pageNumbers[] = $i;
                    }
                }
            }
        }

        // 去重并排序
        $pageNumbers = array_unique($pageNumbers);
        sort($pageNumbers);

        return $pageNumbers;
    }

    /**
     * 生成输出文件名
     * 
     * @param string $inputPath 输入文件路径
     * @param int $pageNumber 页码
     * @param string $format 输出格式
     * @return string 生成的文件名
     */
    private function generateFilename($inputPath, $pageNumber, $format)
    {
        $baseName = pathinfo($inputPath, PATHINFO_FILENAME);
        return $baseName . '_page_' . $pageNumber . '.' . $format;
    }

    /**
     * 检查命令是否存在
     * 
     * @param string $command 命令名称
     * @return bool 命令是否存在
     */
    private function commandExists($command)
    {
        // 尝试直接执行命令检查是否安装
        if ($command === 'gs') {
            $process = proc_open(
                'gs -v',
                [
                    0 => ['pipe', 'r'],
                    1 => ['pipe', 'w'],
                    2 => ['pipe', 'w'],
                ],
                $pipes
            );

            if (is_resource($process)) {
                $output = stream_get_contents($pipes[1]);
                fclose($pipes[0]);
                fclose($pipes[1]);
                fclose($pipes[2]);
                $returnCode = proc_close($process);

                // 如果命令执行成功且输出包含Ghostscript，则认为已安装
                if ($returnCode === 0 && stripos($output, 'Ghostscript') !== false) {
                    return true;
                }
            }
        }

        // 默认检测方法 - 根据操作系统选择合适的命令
        $checkCommand = (PHP_OS_FAMILY === 'Windows') ? 'where' : 'which';
        $process = proc_open(
            $checkCommand . ' ' . escapeshellarg($command),
            [
                0 => ['pipe', 'r'],
                1 => ['pipe', 'w'],
                2 => ['pipe', 'w'],
            ],
            $pipes
        );

        if (is_resource($process)) {
            fclose($pipes[0]);
            fclose($pipes[1]);
            fclose($pipes[2]);
            $returnCode = proc_close($process);
            return $returnCode === 0;
        }

        return false;
    }

    /**
     * 递归删除目录
     * 
     * @param string $dir 要删除的目录
     * @return bool 是否成功删除
     */
    private function removeDirectory($dir)
    {
        if (!is_dir($dir)) {
            return false;
        }

        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            $path = $dir . '/' . $file;
            is_dir($path) ? $this->removeDirectory($path) : unlink($path);
        }

        return rmdir($dir);
    }

    /**
     * 获取系统信息
     * 
     * @return array 系统信息数组
     */
    public function getSystemInfo()
    {
        $info = [
            'php_version' => PHP_VERSION,
            'os' => PHP_OS,
            'imagick_installed' => extension_loaded('imagick'),
            'ghostscript_installed' => $this->commandExists('gs'),
            'pdftk_installed' => $this->commandExists('pdftk'),
            'poppler_installed' => $this->commandExists('pdftoppm'),
            'pdfinfo_installed' => $this->commandExists('pdfinfo'),
        ];

        if ($info['imagick_installed']) {
            $imagick = new Imagick();
            $info['imagick_version'] = $imagick->getVersion()['versionString'];
        }

        return $info;
    }
}
