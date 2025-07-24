<?php

namespace app\api\controller;

use app\api\extend\ChunkUploader;
use app\api\extend\WordProcessor;
use app\api\extend\PdfProcessor;
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
    public function addPrintList($filename, $url)
    {
        //默认选项
        $printSetting = \app\api\model\PrintSetting::where(['is_default' => 1,'status'=>1])->field(['name', 'price', 'type','value'])->select()->toArray();
        //读取文件页数
        $totalPage = 0;
        //根据文件后缀判断是pdf还是doc
        $ext = pathinfo($url, PATHINFO_EXTENSION);
        if ($ext === 'pdf') {
            // 使用PDF处理器
            $processor = new PdfProcessor();
            $totalPage = $processor->getPageCount('public'.$url);
        } else {
            // 使用Word处理器
            $processor = new WordProcessor();
            $totalPage = $processor->getPageCount('public'.$url);
        }
    
        //价格
        $paperPrice = array_sum(array_column($printSetting, 'price'));
        $totalPrice = round($paperPrice*$totalPage,2);
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
                'selectPage'    =>  $selectPage,
                'copies'        => 1,
            ]
        ];
    }

}
