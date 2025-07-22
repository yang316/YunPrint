<?php
namespace app\api\controller;

use app\api\extends\ChunkUploader;

class UploadController extends BaseController
{
    protected $noNeedLogin = ['upload'];
    public function upload()
    {
        $uploader = new ChunkUploader();
        $result = $uploader->process();
        return $this->success($result);
    }
}