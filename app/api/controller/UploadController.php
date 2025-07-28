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
        $printSetting = \app\api\model\PrintSetting::where([
                'is_default'    => 1,
                'status'        => 1
            ])->field([
                'id','name', 'price', 'type','value','max_pages'
            ])
            ->select()
            ->toArray();
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
        $printPrice = $this->calcPrintPrice($printSetting,1,$totalPage);
        $totalPrice = $printPrice['totalPrice'];
        $bookNums =   $printPrice['bookNums'];
        $paperPrice = $printPrice['paperPrice'];
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
            'bookNums'          => $bookNums,
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
                'copies'        =>  1,
            ]
        ];
    }




    /**
     * 计算打印价格
     *
     * @param [type] $options
     * @param [type] $copies
     * @param [type] $totalPage
     * @return void
     */
    public function calcPrintPrice($options,$copies,$totalPage)
    {
     
        //取type = side 和 type = paperType 和type = binding 和 type=coverType的数组
        $targetTypes = ['side', 'paperType', 'binding', 'coverType'];
        // 以 type 为索引重组数组
        $priceOptions = [];
        foreach ($options as $item) {
            if (in_array($item['type'], $targetTypes)) {
                $priceOptions[$item['type']] = $item;
            }
        }
        
        //计算本数
        $binding = $priceOptions['binding']['value'];
        $bookNums = 0;
        $totalPrice = 0;
        $paperPrice = 0;
        //单双面和纸张类型价格
        $sideType = $priceOptions['side']['value'];
        $paperType = $priceOptions['paperType']['value'];
        $paperPrice = floatval($priceOptions['paperType']['price']);
        $coverType = $priceOptions['coverType']['value'];
        
        //计算实际打印页数（考虑单双面）
        $actualPages = $sideType == 'single' ? $totalPage : ceil($totalPage / 2);
        
        //计算装订本数和装订价格
        $bindingPrice = 0;
        switch($binding){
            //不装钉
            case 'none':
                $bindingPrice = 0;
                break;
            //铜版纸胶装： 超600页 +1元 超800页+2元 超1000页分2本 每本价格5元
            case 'steel':
                if($actualPages <= 600) {
                    $bookNums = 1;
                    $bindingPrice = 5;
                } else if($actualPages <= 800) {
                    $bookNums = 1;
                    $bindingPrice = 6; //5+1
                } else if($actualPages <= 1000) {
                    $bookNums = 1;
                    $bindingPrice = 7; //5+2
                } else {
                    $bookNums = ceil($actualPages / 1000);
                    $bindingPrice = 5 * $bookNums;
                }
                break;
            //平订 最多200页 超200页 分成每200页一本平订，每本价格0.2元
            case 'staple':
                $bookNums = max(1, ceil($actualPages / 200));
                $bindingPrice = 0.2 * $bookNums;
                break;
            //皮纹纸胶装 超600页 +1元 超800页+2元 超1000页分2本 每本价格3元
            case 'textured_binding':
                if($actualPages <= 600) {
                    $bookNums = 1;
                    $bindingPrice = 3;
                } else if($actualPages <= 800) {
                    $bookNums = 1;
                    $bindingPrice = 4; //3+1
                } else if($actualPages <= 1000) {
                    $bookNums = 1;
                    $bindingPrice = 5; //3+2
                } else {
                    $bookNums = ceil($actualPages / 1000);
                    $bindingPrice = 3 * $bookNums;
                }
                break;
            //铁圈最多220页 每本价格5元
            case 'wire_binding':
                $bookNums = max(1, ceil($actualPages / 220));
                $bindingPrice = 5 * $bookNums;
                break;
            //骑马钉 最多60页 每本价格1元
            case 'saddle_stitch':
                $bookNums = max(1, ceil($actualPages / 60));
                $bindingPrice = 1 * $bookNums;
                break;

        }
        
        //总价格计算：(纸张价格 * 实际页数 * 份数) + (装订价格 * 本数 * 份数)
        $totalPrice = round(($paperPrice * $actualPages * $copies) + ($bindingPrice * $bookNums * $copies), 2);
        return ['totalPrice'=>$totalPrice,'bookNums'=>$bookNums,'bindingPrice'=>$bindingPrice,'paperPrice'=>$paperPrice];
    }
}
