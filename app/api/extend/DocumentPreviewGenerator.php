<?php

namespace app\api\extend;
/**
 * 文档预览图生成器 PHP 调用类
 * 调用Python脚本生成PDF、DOC、DOCX的预览图
 */

class DocumentPreviewGenerator
{
    private $pythonPath;
    private $scriptPath;
    private $defaultOutputDir;
    
    public function __construct($pythonPath = 'python3', $scriptPath = null, $defaultOutputDir = null)
    {
        $this->pythonPath = $pythonPath;
        $this->scriptPath = $scriptPath ?:'public/documentPreview.py';
        $this->defaultOutputDir = $defaultOutputDir ?: sys_get_temp_dir() . '/document_previews';
    }
    
    /**
     * 生成文档预览图
     * 
     * @param string $filePath 文档文件路径
     * @param array $options 配置选项
     * @return array 生成结果
     */
    public function generatePreview($filePath, $options = [])
    {
        // 默认配置
        $defaultOptions = [
            'output_dir' => $this->defaultOutputDir,
            'pages' => null,        // 页码: null(全部), 1(第1页), "1-3"(1到3页), "1,3,5"(指定页)
            'dpi' => 150,          // 图片DPI
            'enhance' => true,     // 是否增强图片质量
            'thumbnail' => true,   // 是否生成缩略图
            'thumb_width' => 300,  // 缩略图宽度
            'thumb_height' => 400  // 缩略图高度
        ];
        
        $options = array_merge($defaultOptions, $options);
        
        // 验证文件是否存在
        if (!file_exists($filePath)) {
            return [
                'success' => false,
                'error' => '文件不存在: ' . $filePath
            ];
        }
        
        // 验证Python脚本是否存在
        if (!file_exists($this->scriptPath)) {
            return [
                'success' => false,
                'error' => 'Python脚本不存在: ' . $this->scriptPath
            ];
        }
        
        // 创建输出目录
        if (!is_dir($options['output_dir'])) {
            mkdir($options['output_dir'], 0755, true);
        }
        
        // 构建命令
        $command = $this->buildCommand($filePath, $options);
        
        // 执行命令
        $output = shell_exec($command . ' 2>&1');
        
        // 解析输出
        $result = $this->parseOutput($output);
        
        return $result;
    }
    
    /**
     * 构建Python命令
     */
    private function buildCommand($filePath, $options)
    {
        $command = sprintf(
            '%s "%s" "%s" "%s"',
            $this->pythonPath,
            $this->scriptPath,
            $filePath,
            $options['output_dir']
        );
        
        // 添加可选参数
        if ($options['pages'] !== null) {
            $command .= ' --pages "' . $options['pages'] . '"';
        }
        
        if ($options['dpi'] !== 150) {
            $command .= ' --dpi ' . $options['dpi'];
        }
        
        if (!$options['enhance']) {
            $command .= ' --no-enhance';
        }
        
        if (!$options['thumbnail']) {
            $command .= ' --no-thumbnail';
        }
        
        if ($options['thumb_width'] !== 300) {
            $command .= ' --thumb-width ' . $options['thumb_width'];
        }
        
        if ($options['thumb_height'] !== 400) {
            $command .= ' --thumb-height ' . $options['thumb_height'];
        }
        
        return $command;
    }
    
    /**
     * 解析Python脚本输出
     */
    private function parseOutput($output)
    {
        if (empty($output)) {
            return [
                'success' => false,
                'error' => 'Python脚本无输出'
            ];
        }
        
        $result = json_decode($output, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            return [
                'success' => false,
                'error' => 'JSON解析失败',
                'raw_output' => $output
            ];
        }
        
        return $result;
    }
    
    /**
     * 获取支持的文件格式
     */
    public function getSupportedFormats()
    {
        return ['.pdf', '.doc', '.docx'];
    }
    
    /**
     * 检查文件格式是否支持
     */
    public function isFormatSupported($filePath)
    {
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        return in_array('.' . $extension, $this->getSupportedFormats());
    }
    
    /**
     * 清理输出目录中的旧文件
     */
    public function cleanupOldFiles($outputDir, $maxAge = 3600)
    {
        if (!is_dir($outputDir)) {
            return false;
        }
        
        $files = glob($outputDir . '/*');
        $now = time();
        $cleaned = 0;
        
        foreach ($files as $file) {
            if (is_file($file) && ($now - filemtime($file)) > $maxAge) {
                unlink($file);
                $cleaned++;
            }
        }
        
        return $cleaned;
    }
}

// 使用示例
if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) {
    // 示例用法
    $generator = new DocumentPreviewGenerator();
    
    // 示例1: 生成PDF第1页预览图
    $result1 = $generator->generatePreview('/path/to/document.pdf', [
        'pages' => 1,
        'output_dir' => './previews/pdf_demo'
    ]);
    
    echo "示例1结果:\n";
    print_r($result1);
    
    // 示例2: 生成DOCX文档的前3页预览图
    $result2 = $generator->generatePreview('/path/to/document.docx', [
        'pages' => '1-3',
        'dpi' => 200,
        'output_dir' => './previews/docx_demo'
    ]);
    
    echo "\n示例2结果:\n";
    print_r($result2);
    
    // 示例3: 生成指定页码的预览图
    $result3 = $generator->generatePreview('/path/to/document.pdf', [
        'pages' => '1,3,5',
        'enhance' => false,
        'thumbnail' => false,
        'output_dir' => './previews/custom_pages'
    ]);
    
    echo "\n示例3结果:\n";
    print_r($result3);
}
?>