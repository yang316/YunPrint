<?php

namespace app\api\extend;

use Exception;
use ZipArchive;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory as PhpWordIOFactory;
use PhpOffice\PhpWord\Element\Text;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\Element\Image;

/**
 * Word文档处理类
 * 提供Word文档的预览图生成、页数读取和合并功能
 */
class WordProcessor
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
     * PDF处理器实例
     * @var PdfProcessor
     */
    private PdfProcessor $pdfProcessor;
    
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
        
        // 初始化PDF处理器
        $this->pdfProcessor = new PdfProcessor($this->tempDir, $this->outputDir, $this->mergeOutputDir);
    }
    
    /**
     * 生成Word文档的预览图
     * 
     * @param string $wordPath Word文档路径
     * @param array|string $pages 要生成预览图的页码，可以是数组、范围字符串或'all'
     * @param int $resolution 分辨率
     * @param string $format 输出图片格式
     * @param int $quality 图片质量
     * @return array 生成的预览图路径数组
     * @throws Exception 处理失败时抛出异常
     */
    public function generatePreviewImages($wordPath, $pages = 'all', $resolution = 150, $format = 'jpg', $quality = 90)
    {
        // 验证文件存在
        if (!file_exists($wordPath)) {
            throw new Exception('Word文档不存在: ' . $wordPath);
        }
        
        // 获取文件扩展名
        $ext = strtolower(pathinfo($wordPath, PATHINFO_EXTENSION));
        if ($ext !== 'doc' && $ext !== 'docx') {
            throw new Exception('不是有效的Word文档: ' . $wordPath);
        }
        
        // 将Word文档转换为PDF
        $pdfPath = $this->convertWordToPdf($wordPath);
        
        try {
            // 获取总页数
            $totalPages = $this->getPageCount($wordPath);
            if ($totalPages <= 0) {
                throw new Exception('无法获取Word文档页数或文档为空');
            }
            
            // 使用PDF处理器生成预览图
            return $this->pdfProcessor->generatePreviewImages($pdfPath, $pages, $resolution, $format, $quality);
        } finally {
            // 清理临时PDF文件
            if (file_exists($pdfPath)) {
                unlink($pdfPath);
            }
        }
    }
    
    /**
     * 将Word文档转换为PDF
     * 
     * @param string $wordPath Word文档路径
     * @return string 生成的PDF文件路径
     * @throws Exception 转换失败时抛出异常
     */
    private function convertWordToPdf($wordPath)
    {
        // 生成临时PDF文件路径
        $pdfPath = $this->tempDir . '/' . uniqid('word_to_pdf_', true) . '.pdf';
        
        // 尝试使用PhpWord转换
        try {
            // 加载Word文档
            $phpWord = PhpWordIOFactory::load($wordPath);
            
            // 保存为PDF
            $pdfWriter = PhpWordIOFactory::createWriter($phpWord, 'PDF');
            $pdfWriter->save($pdfPath);
            
            if (file_exists($pdfPath) && filesize($pdfPath) > 0) {
                return $pdfPath;
            }
        } catch (Exception $e) {
            error_log('PhpWord转换Word到PDF失败: ' . $e->getMessage());
            // 继续尝试其他方法
        }
        
        // 尝试使用LibreOffice/OpenOffice转换
        if ($this->commandExists('soffice')) {
            $command = sprintf(
                'soffice --headless --convert-to pdf --outdir %s %s 2>&1',
                escapeshellarg($this->tempDir),
                escapeshellarg($wordPath)
            );
            
            $output = [];
            $returnCode = 0;
            exec($command, $output, $returnCode);
            
            $filename = pathinfo($wordPath, PATHINFO_FILENAME) . '.pdf';
            $convertedPdf = $this->tempDir . '/' . $filename;
            
            if ($returnCode === 0 && file_exists($convertedPdf) && filesize($convertedPdf) > 0) {
                // 重命名为唯一文件名
                if (rename($convertedPdf, $pdfPath)) {
                    return $pdfPath;
                }
            }
        }
        
        // 尝试使用wvPDF (wvWare)转换
        if ($this->commandExists('wvPDF')) {
            $command = sprintf(
                'wvPDF %s %s 2>&1',
                escapeshellarg($wordPath),
                escapeshellarg($pdfPath)
            );
            
            $output = [];
            $returnCode = 0;
            exec($command, $output, $returnCode);
            
            if ($returnCode === 0 && file_exists($pdfPath) && filesize($pdfPath) > 0) {
                return $pdfPath;
            }
        }
        
        throw new Exception('无法将Word文档转换为PDF');
    }
    
    /**
     * 获取Word文档的页数
     * 
     * @param string $wordPath Word文档路径
     * @return int 页数
     * @throws Exception 处理失败时抛出异常
     */
    public function getPageCount($wordPath)
    {
        // 验证文件存在
        if (!file_exists($wordPath)) {
            throw new Exception('Word文档不存在: ' . $wordPath);
        }
        
        // 获取文件扩展名
        $ext = strtolower(pathinfo($wordPath, PATHINFO_EXTENSION));
        
        // 对于DOCX文件，尝试从docProps/app.xml读取页数
        if ($ext === 'docx') {
            try {
                $zip = new ZipArchive();
                if ($zip->open($wordPath) === true) {
                    // 尝试读取app.xml文件
                    $appXml = $zip->getFromName('docProps/app.xml');
                    $zip->close();
                    
                    if ($appXml) {
                        // 解析XML以获取页数
                        $xml = simplexml_load_string($appXml);
                        $pages = (int)$xml->Pages;
                        
                        if ($pages > 0) {
                            return $pages;
                        }
                    }
                }
            } catch (Exception $e) {
                // 继续尝试其他方法
            }
        }
        
        // 对于DOC文件或上述方法失败，转换为PDF并获取页数
        try {
            $pdfPath = $this->convertWordToPdf($wordPath);
            $pageCount = $this->pdfProcessor->getPageCount($pdfPath);
            
            // 清理临时PDF文件
            if (file_exists($pdfPath)) {
                unlink($pdfPath);
            }
            
            return $pageCount;
        } catch (Exception $e) {
            throw new Exception('无法获取Word文档页数: ' . $e->getMessage());
        }
    }
    
    /**
     * 合并多个Word文档
     * 
     * @param array $files 要合并的Word文档路径数组
     * @param string|null $outputPath 输出文件路径，如果为null则自动生成
     * @param string $format 输出格式，'docx'或'pdf'
     * @param bool $usePhpWord 是否使用PhpWord直接合并
     * @param bool $useTempMethod 是否使用临时文件方式合并
     * @return string 合并后的文件路径
     * @throws Exception 合并失败时抛出异常
     */
    public function mergeWordFiles(array $files, $outputPath = null, $format = 'docx', $usePhpWord = true, $useTempMethod = false)
    {
        // 验证文件列表
        if (empty($files)) {
            throw new Exception('没有提供要合并的文件');
        }
        
        // 验证所有文件都是Word文档
        foreach ($files as $file) {
            if (!file_exists($file)) {
                throw new Exception('文件不存在: ' . $file);
            }
            
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if ($ext !== 'doc' && $ext !== 'docx') {
                throw new Exception('只能合并Word文档，发现非Word文件: ' . $file);
            }
        }
        
        // 如果未提供输出路径，则自动生成
        if ($outputPath === null) {
            // 确保目录存在并可写
            if (!is_dir($this->mergeOutputDir)) {
                mkdir($this->mergeOutputDir, 0755, true);
            }
            
            // 使用绝对路径
            $outputPath = $this->mergeOutputDir . '/' . uniqid('merged_', true) . '.' . $format;
            
            // 记录输出路径
            error_log("Word合并输出路径: " . $outputPath);
        }
        
        // 记录要合并的文件
        error_log("要合并的Word文件列表: " . implode(", ", $files));
        
        // 根据参数选择合并方法
        if ($useTempMethod) {
            return $this->mergeWordFilesByTemp($files, $outputPath, $format);
        } elseif ($usePhpWord) {
            return $this->mergeWordFilesByPhpWord($files, $outputPath, $format);
        } else {
            // 如果都不使用，则尝试所有方法
            try {
                return $this->mergeWordFilesByPhpWord($files, $outputPath, $format);
            } catch (Exception $e) {
                error_log('PhpWord合并失败，尝试临时文件方法: ' . $e->getMessage());
                return $this->mergeWordFilesByTemp($files, $outputPath, $format);
            }
        }
    }
    
    /**
     * 使用PhpWord合并Word文档
     * 
     * @param array $files 要合并的Word文档路径数组
     * @param string $outputPath 输出文件路径
     * @param string $format 输出格式，'docx'或'pdf'
     * @return string 合并后的文件路径
     * @throws Exception 合并失败时抛出异常
     */
    private function mergeWordFilesByPhpWord(array $files, $outputPath, $format)
    {
        try {
            // 创建新的PhpWord实例
            $phpWord = new PhpWord();
            
            // 遍历所有文件
            foreach ($files as $file) {
                error_log("处理文件: {$file}");
                
                try {
                    // 加载Word文档
                    $source = PhpWordIOFactory::load($file);
                    
                    // 遍历所有节
                    $sections = $source->getSections();
                    foreach ($sections as $section) {
                        // 创建新节
                        $newSection = $phpWord->addSection();
                        
                        // 复制节的属性
                        $sectionStyle = $section->getStyle();
                        $newSection->setStyle($sectionStyle);
                        
                        // 遍历节中的所有元素
                        $elements = $section->getElements();
                        foreach ($elements as $element) {
                            // 根据元素类型处理
                            if ($element instanceof Text) {
                                // 文本元素
                                $text = $element->getText();
                                $fontStyle = $element->getFontStyle();
                                $paragraphStyle = $element->getParagraphStyle();
                                $newSection->addText($text, $fontStyle, $paragraphStyle);
                            } elseif ($element instanceof TextRun) {
                                // 文本运行元素
                                $textRun = $newSection->addTextRun();
                                $innerElements = $element->getElements();
                                foreach ($innerElements as $innerElement) {
                                    if ($innerElement instanceof Text) {
                                        $text = $innerElement->getText();
                                        $fontStyle = $innerElement->getFontStyle();
                                        $textRun->addText($text, $fontStyle);
                                    } elseif ($innerElement instanceof Image) {
                                        try {
                                            // 获取图片数据
                                            $imageData = null;
                                            $imagePath = $innerElement->getPath();
                                            $imageSource = $innerElement->getSource();
                                            
                                            // 尝试从路径获取图片数据
                                            if (!empty($imagePath) && file_exists($imagePath)) {
                                                $imageData = $imagePath;
                                            } 
                                            // 尝试从源获取图片数据
                                            elseif (!empty($imageSource)) {
                                                $imageData = $imageSource;
                                            }
                                            
                                            if ($imageData) {
                                                // 获取图片尺寸
                                                $width = $innerElement->getWidth();
                                                $height = $innerElement->getHeight();
                                                
                                                // 如果没有尺寸，尝试获取
                                                if (empty($width) || empty($height)) {
                                                    $imgSize = getimagesize($imageData);
                                                    if ($imgSize) {
                                                        $width = $imgSize[0];
                                                        $height = $imgSize[1];
                                                    }
                                                }
                                                
                                                // 添加图片到文本运行
                                                $textRun->addImage($imageData, [
                                                    'width' => $width,
                                                    'height' => $height,
                                                    'alignment' => $innerElement->getAlignment(),
                                                ]);
                                            } else {
                                                error_log("无法获取图片数据");
                                            }
                                        } catch (Exception $e) {
                                            error_log("添加图片失败: " . $e->getMessage());
                                        }
                                    }
                                }
                            } elseif ($element instanceof Table) {
                                // 表格元素
                                $table = $newSection->addTable($element->getStyle());
                                $rows = $element->getRows();
                                foreach ($rows as $row) {
                                    $tableRow = $table->addRow($row->getHeight(), $row->getStyle());
                                    $cells = $row->getCells();
                                    foreach ($cells as $cell) {
                                        $tableCell = $tableRow->addCell($cell->getWidth(), $cell->getStyle());
                                        $cellElements = $cell->getElements();
                                        foreach ($cellElements as $cellElement) {
                                            if ($cellElement instanceof Text) {
                                                $tableCell->addText(
                                                    $cellElement->getText(),
                                                    $cellElement->getFontStyle(),
                                                    $cellElement->getParagraphStyle()
                                                );
                                            } elseif ($cellElement instanceof TextRun) {
                                                $textRun = $tableCell->addTextRun();
                                                $innerElements = $cellElement->getElements();
                                                foreach ($innerElements as $innerElement) {
                                                    if ($innerElement instanceof Text) {
                                                        $textRun->addText(
                                                            $innerElement->getText(),
                                                            $innerElement->getFontStyle()
                                                        );
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            } elseif ($element instanceof Image) {
                                try {
                                    // 获取图片数据
                                    $imageData = null;
                                    $imagePath = $element->getPath();
                                    $imageSource = $element->getSource();
                                    
                                    // 尝试从路径获取图片数据
                                    if (!empty($imagePath) && file_exists($imagePath)) {
                                        $imageData = $imagePath;
                                    } 
                                    // 尝试从源获取图片数据
                                    elseif (!empty($imageSource)) {
                                        $imageData = $imageSource;
                                    }
                                    
                                    if ($imageData) {
                                        // 获取图片尺寸
                                        $width = $element->getWidth();
                                        $height = $element->getHeight();
                                        
                                        // 如果没有尺寸，尝试获取
                                        if (empty($width) || empty($height)) {
                                            $imgSize = getimagesize($imageData);
                                            if ($imgSize) {
                                                $width = $imgSize[0];
                                                $height = $imgSize[1];
                                            }
                                        }
                                        
                                        // 添加图片到节
                                        $newSection->addImage($imageData, [
                                            'width' => $width,
                                            'height' => $height,
                                            'alignment' => $element->getAlignment(),
                                        ]);
                                    } else {
                                        error_log("无法获取图片数据");
                                    }
                                } catch (Exception $e) {
                                    error_log("添加图片失败: " . $e->getMessage());
                                }
                            }
                        }
                    }
                } catch (Exception $e) {
                    error_log("处理文件 {$file} 失败: " . $e->getMessage());
                    throw $e;
                }
            }
            
            // 根据格式保存文件
            if ($format === 'pdf') {
                $writer = PhpWordIOFactory::createWriter($phpWord, 'PDF');
            } else {
                $writer = PhpWordIOFactory::createWriter($phpWord, 'Word2007');
            }
            
            // 保存文件
            $writer->save($outputPath);
            
            // 检查输出文件
            if (file_exists($outputPath) && filesize($outputPath) > 0) {
                error_log("PhpWord合并成功，文件大小: " . filesize($outputPath));
                return $outputPath;
            } else {
                error_log("PhpWord合并失败，文件不存在或为空");
                throw new Exception("PhpWord合并失败，文件不存在或为空");
            }
        } catch (Exception $e) {
            error_log("PhpWord合并失败: " . $e->getMessage());
            throw new Exception('PhpWord合并Word文档失败: ' . $e->getMessage());
        }
    }
    
    /**
     * 使用临时文件方式合并Word文档
     * 
     * @param array $files 要合并的Word文档路径数组
     * @param string $outputPath 输出文件路径
     * @param string $format 输出格式，'docx'或'pdf'
     * @return string 合并后的文件路径
     * @throws Exception 合并失败时抛出异常
     */
    private function mergeWordFilesByTemp(array $files, $outputPath, $format)
    {
        // 如果输出格式是PDF，则先将所有Word转为PDF，然后合并PDF
        if ($format === 'pdf') {
            $pdfFiles = [];
            
            try {
                // 转换所有Word文档为PDF
                foreach ($files as $file) {
                    $pdfFile = $this->convertWordToPdf($file);
                    $pdfFiles[] = $pdfFile;
                }
                
                // 合并PDF文件
                return $this->pdfProcessor->mergePdfFiles($pdfFiles, $outputPath);
            } finally {
                // 清理临时PDF文件
                foreach ($pdfFiles as $pdfFile) {
                    if (file_exists($pdfFile)) {
                        unlink($pdfFile);
                    }
                }
            }
        }
        
        // 如果输出格式是DOCX，则使用LibreOffice/OpenOffice合并
        if ($this->commandExists('soffice')) {
            // 创建临时目录
            $tempDir = $this->tempDir . '/' . uniqid('word_merge_', true);
            if (!mkdir($tempDir, 0755, true)) {
                throw new Exception('无法创建临时目录');
            }
            
            try {
                // 复制所有文件到临时目录
                $tempFiles = [];
                foreach ($files as $index => $file) {
                    $tempFile = $tempDir . '/' . sprintf('%03d', $index) . '_' . basename($file);
                    if (!copy($file, $tempFile)) {
                        throw new Exception('无法复制文件到临时目录: ' . $file);
                    }
                    $tempFiles[] = $tempFile;
                }
                
                // 使用LibreOffice/OpenOffice合并文件
                $fileArgs = implode(' ', array_map('escapeshellarg', $tempFiles));
                $command = sprintf(
                    'soffice --headless --convert-to %s --outdir %s %s 2>&1',
                    escapeshellarg($format),
                    escapeshellarg($this->tempDir),
                    $fileArgs
                );
                
                $output = [];
                $returnCode = 0;
                exec($command, $output, $returnCode);
                
                if ($returnCode !== 0) {
                    throw new Exception('LibreOffice合并失败: ' . implode("\n", $output));
                }
                
                // 查找生成的文件
                $generatedFiles = glob($this->tempDir . '/*.' . $format);
                if (empty($generatedFiles)) {
                    throw new Exception('LibreOffice未能生成输出文件');
                }
                
                // 移动生成的文件到输出路径
                if (!rename($generatedFiles[0], $outputPath)) {
                    throw new Exception('无法移动合并后的文件到输出路径');
                }
                
                // 检查输出文件
                if (file_exists($outputPath) && filesize($outputPath) > 0) {
                    error_log("LibreOffice合并成功，文件大小: " . filesize($outputPath));
                    return $outputPath;
                } else {
                    error_log("LibreOffice合并失败，文件不存在或为空");
                    throw new Exception("LibreOffice合并失败，文件不存在或为空");
                }
            } finally {
                // 清理临时目录
                if (is_dir($tempDir)) {
                    $this->removeDirectory($tempDir);
                }
            }
        }
        
        // 如果LibreOffice/OpenOffice不可用，则尝试使用PhpWord
        return $this->mergeWordFilesByPhpWord($files, $outputPath, $format);
    }
    
    /**
     * 检查命令是否存在
     * 
     * @param string $command 命令名称
     * @return bool 命令是否存在
     */
    private function commandExists($command)
    {
        $whereCommand = (PHP_OS == 'WINNT') ? 'where' : 'which';
        $process = proc_open(
            $whereCommand . ' ' . escapeshellarg($command),
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
            'phpword_installed' => class_exists('\PhpOffice\PhpWord\PhpWord'),
            'libreoffice_installed' => $this->commandExists('soffice'),
            'wvpdf_installed' => $this->commandExists('wvPDF'),
        ];
        
        return $info;
    }
}