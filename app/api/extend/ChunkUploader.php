<?php

namespace app\api\extend;
/**
 * 分片上传工具类
 * 支持大文件分片上传和断点续传
 * 使用示例：
 * $uploader = new ChunkUploader();
 * $result = $uploader->upload();
 * 或静态调用：
 * $result = ChunkUploader::upload();
 */
use Exception;

class ChunkUploader
{
    // 配置项
    protected $config = [
        'upload_dir' => 'uploads/',           // 上传目录（相对于public）
        'chunk_dir' => 'chunks/',             // 分片临时存储目录（相对于runtime）
        'max_file_size' => 150 * 1024 * 1024, // 最大文件大小 1GB
        'allowed_extensions' => ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'txt', 'mp4'], // 允许的文件类型
        'use_static' => false,                // 是否使用静态模式
    ];

    // 上传结果
    protected $result = [
        'status' => 'error',
        'message' => '',
        'data' => []
    ];

    /**
     * 构造函数
     * @param array $config 配置参数
     */
    public function __construct(array $config = [])
    {
        $this->config = array_merge($this->config, $config);
    
    }
    /**
     * 递归删除目录
     * @param string $dir 目录路径
     * @return bool
     */
    protected function deleteDirectory($dir)
    {
        if (!is_dir($dir)) {
            return false;
        }
        
        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            $path = $dir . '/' . $file;
            is_dir($path) ? $this->deleteDirectory($path) : unlink($path);
        }
        
        return rmdir($dir);
    }


    /**
     * 静态调用入口
     * @param array $config 配置参数
     * @return array 上传结果
     */
    protected static function upload(array $config = [])
    {
        $config['use_static'] = true;
        return (new static($config))->process();
    }

    /**
     * 处理上传请求
     * @return array 上传结果
     */
    public function process()
    {
        try {
            // 创建必要的目录
            $this->createRequiredDirectories();
            
            // 检查请求类型
            $requestMethod = request()->method();
            
            if ($requestMethod === 'POST') {
                // 处理分片上传
                return $this->processChunkUpload();
            } elseif ($requestMethod === 'GET') {
                // 检查文件或分片是否已存在（用于断点续传）
                return $this->checkFileOrChunkExists();
            } else {
                throw new Exception('不支持的请求方法', 405);
            }
        } catch (Exception $e) {
            return $this->setError($e->getMessage(), $e->getCode());
        }
    }

    /**
     * 创建必要的目录
     */
    protected function createRequiredDirectories()
    {
        // 创建上传目录
        $uploadPath = runtime_path('storage/' . $this->config['upload_dir']);
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        
        // 创建临时分片目录
        $chunkPath = runtime_path($this->config['chunk_dir']);
        if (!is_dir($chunkPath)) {
            mkdir($chunkPath, 0755, true);
        }
    }

    /**
     * 处理分片上传
     */
    protected function processChunkUpload()
    {
        // 验证上传文件
        $file = request()->file('chunk');
        if (!$file) {
            throw new Exception('未上传文件分片', 400);
        }
        
        // 获取必要参数
        $fileId = request()->post('fileId', '');
        $fileName = request()->post('fileName', '')??urldecode(request()->post('filename'));
        $chunkIndex = (int) request()->post('chunkIndex', 0);
        $totalChunks = (int) request()->post('totalChunks', 1);
        
        // 验证参数
        if (empty($fileId) || empty($fileName)) {
            throw new Exception('缺少必要参数', 400);
        }
        
        // 验证文件类型
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (!in_array($fileExtension, $this->config['allowed_extensions'])) {
            throw new Exception('不允许的文件类型', 400);
        }
        
        // 验证文件大小
        if ($file->getSize() > $this->config['max_file_size']) {
            throw new Exception('文件大小超过限制', 400);
        }
        
        // 保存分片
        $chunkDir = runtime_path($this->config['chunk_dir'] . '/' . $fileId);
        if (!is_dir($chunkDir)) {
            mkdir($chunkDir, 0755, true);
        }
        
        $chunkPath = $chunkDir . '/' . $chunkIndex;
        
        try {
            // 保存上传的分片
            if (!$file->isValid()) {
                throw new Exception('无效的上传文件', 400);
            }
            $file->move($chunkPath);
        } catch (\Exception $e) {
            throw new Exception('保存分片失败: ' . $e->getMessage(), 500);
        }
        
        // 检查是否所有分片都已上传
        if ($chunkIndex === $totalChunks - 1) {
            // 检查所有分片是否都已上传
            $existingChunks = scandir($chunkDir);
            $chunkCount = count($existingChunks) - 2; // 减去 . 和 .. 两个目录
            
            if ($chunkCount === $totalChunks) {
                // 合并所有分片
                $uploadDir = public_path($this->config['upload_dir']);
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                $uploadPath = $uploadDir . '/' . $fileName;
                $this->mergeChunks($chunkDir, $uploadPath, $totalChunks);
                
                // 清理临时文件
                $this->deleteDirectory($chunkDir);
                
                return $this->setSuccess('文件上传完成', [
                    'filePath' => '/' . $this->config['upload_dir'] . $fileName,
                    'savePath' => $this->config['upload_dir'] . $fileName,
                    'filename' => $fileName
                ]);
            }
        }
        
        return $this->setSuccess('分片上传成功', [
            'chunkIndex' => $chunkIndex
        ]);
    }

    /**
     * 检查文件或分片是否已存在
     */
    protected function checkFileOrChunkExists()
    {
        $fileId = request()->get('fileId', '');
        $chunkIndex = request()->has('chunkIndex') ? (int) request()->get('chunkIndex') : null;
        
        if (empty($fileId)) {
            throw new Exception('缺少必要参数', 400);
        }
        
        $chunkDir = runtime_path($this->config['chunk_dir'] . '/' . $fileId);
        
        if ($chunkIndex !== null) {
            // 检查单个分片
            $chunkPath = $chunkDir . '/' . $chunkIndex;
            return $this->setSuccess('', [
                'exists' => file_exists($chunkPath)
            ]);
        } else {
            // 检查整个文件的所有分片
            $existingChunks = [];
            if (is_dir($chunkDir)) {
                $files = scandir($chunkDir);
                foreach ($files as $file) {
                    if ($file != '.' && $file != '..') {
                        $existingChunks[] = (int) $file;
                    }
                }
            }
            
            return $this->setSuccess('', [
                'existingChunks' => $existingChunks
            ]);
        }
    }

    /**
     * 合并所有分片
     */
    protected function mergeChunks($chunkDir, $uploadPath, $totalChunks)
    {
        // 打开目标文件用于写入
        $fp = fopen($uploadPath, 'wb');
        if (!$fp) {
            throw new Exception('无法创建目标文件', 500);
        }
        
        for ($i = 0; $i < $totalChunks; $i++) {
            $chunkPath = $chunkDir . '/' . $i;
            if (file_exists($chunkPath)) {
                // 读取分片内容并写入目标文件
                $chunkData = file_get_contents($chunkPath);
                fwrite($fp, $chunkData);
            } else {
                fclose($fp);
                // 删除不完整的文件
                if (file_exists($uploadPath)) {
                    unlink($uploadPath);
                }
                throw new Exception("缺少分片 #$i", 500);
            }
        }
        
        fclose($fp);
    }

    /**
     * 设置成功结果
     * @param string $message 消息
     * @param array $data 数据
     * @return array
     */
    protected function setSuccess($message, $data = [])
    {
        $this->result['status'] = 'success';
        $this->result['message'] = $message;
        $this->result['data'] = $data;
        $this->result['code'] = 200;
        return $this->result;
    }

    /**
     * 设置错误结果
     * @param string $message 消息
     * @param int $code 错误码
     * @return array
     */
    protected function setError($message, $code = 500)
    {
        $this->result['status'] = 'error';
        $this->result['message'] = $message;
        $this->result['code'] = $code;
        return $this->result;
    }
}