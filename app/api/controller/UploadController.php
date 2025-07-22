<?php

namespace app\api\controller;

use app\api\extend\ChunkUploader;
use app\api\extend\DocumentToImage;
class UploadController extends BaseController
{
    protected $noNeedLogin = ['getFilePage'];


    /**
     * 分片上传文件
     *
     * @return void
     */
    public function upload()
    {
        //分片上传文件
        $uploader = new ChunkUploader();

        $result = $uploader->process();

        if ($result['code'] == 500) {

            return $this->error($result['msg']);

        } elseif ($result['code'] == 200 && isset($result['data']['filename'])) {

            $fileName   = $result['data']['filename'];

            $url        = $result['data']['filePath'];

            $addResult = $this->addPrintList($fileName, $url);

            if ($addResult['status'] == 'fail') {

                return $this->error($addResult['msg']);

            }
            $return = array_merge($result['data'], $addResult['data']);

            return $this->success($return, '操作成功');
        }else{
            return $this->success($result['data'],$result['message']);
        }
    }



    /**
     * 添加到待打印列表
     */
    private function addPrintList($filename, $url)
    {
        //默认选项
        $printSetting = \app\api\model\PrintSetting::where(['is_default' => 1,'status'=>1])->field(['name', 'price', 'type','value'])->select()->toArray();
        //读取文件页数
        $totalPage = 0;
        $document = new DocumentToImage();
        try {
            // 使用新的统一方法获取文档页数
            $totalPage = $document->getDocumentPageCount('public'.$url);
        } catch (\Exception $e) {
            // 如果获取页数失败，记录错误并设置默认页数为1
            return $this->error('获取页数失败');
        }
        //价格
        $paperPrice = array_sum(array_column($printSetting, 'price'));
        $totalPrice = bcmul($paperPrice,$totalPage,2);
        //选定页数
        $selectPage = ['start'=>1,'end'=>$totalPage];
        //保存数据
        $result = \app\api\model\UserAttachment::create([
            'user_id'           => $this->request->user['id'],
            'url'               => $url,
            'file_name'         => $filename,
            'total'             => $totalPage,
            'options'           => $printSetting,
            'selectPage'        => $selectPage,
            'paperPrice'        => $paperPrice,
            'totalPrice'        => $totalPrice,
            'copies'            => 1,
        ]);
        if (!$result) {
            return ['status' => 'fail', 'msg' => '添加到打印列表失败'];
        }
        //保存搭配待打印列表
        return [
            'status'    => 'success',
            'msg'       => '添加到打印列表成功',
            'data'      => [
                'paperPrice'    =>  $paperPrice,
                'totalPrice'    =>  $totalPrice,
                'totalPage'     =>  $totalPage,
                'options'       =>  $printSetting,
                'selectPage'    =>  $selectPage
            ]
        ];
    }

    /**
     * 获取文件页数
     *
     * @return void
     */
    public function getFilePage()
    {
        $printSetting = \app\api\model\PrintSetting::where(['is_default' => 1,'status'=>1])->field(['name', 'price', 'type'])->select()->toArray();
        d(json_encode($printSetting));
         $document = new DocumentToImage();
        // try {
            // 使用新的统一方法获取文档页数
            $totalPage = $document->getDocumentPageCount('public/uploads/众联加油小程序端操作文档(1).pdf');
        // } catch (\Exception $e) {
        //     // 如果获取页数失败，记录错误并设置默认页数为1
        //     return $this->error('获取页数失败');
        // }
        d($totalPage);
    }
}
