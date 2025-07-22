<?php

namespace app\api\extend;

class Uploads 
{
    /**
     * 是否上传完成
     */
    protected $complete = false;

    /**
     * 文件上传目录
     */
    protected $uploadDir = 'uploads';

    /**
     *  文件名
     */
    protected $fileName = '';

    /**
     * 分片文件路径
     */
    protected $chunkDir = 'uploads/chunk/';



    /**
     * 上传完成
     */
    public function complete()
    {
        $this->complete = true;
    }

    /**
     * 根据ID合并文件
     */
    public function uploads($file)
    {
        $this->fileName = $file;
        $this->chunkDir = $this->chunkDir . $this->fileName . '/';
        $this->uploadDir = $this->uploadDir . '/' . $this->fileName . '/';
        // $this->createChunkDir();
        // $this->mergeFiles();
        return $this->uploadDir . $this->fileName;
    }

}