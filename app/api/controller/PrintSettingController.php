<?php

namespace app\api\controller;

use app\api\validate\PrintSettingValidate;
use think\exception\ValidateException;
use app\api\extend\DocumentToImage;

class PrintSettingController extends BaseController
{
    protected $noNeedLogin = [];

    /**
     * @var PrintSettingValidate
     */
    protected PrintSettingValidate $validate;

    public function __construct()
    {
        parent::__construct();
        $this->validate = new PrintSettingValidate();
    }

    /**
     * 获取打印设置（按类型分组）
     */
    public function getPrintSetting()
    {
        try {
            // 查询并分组
            $list = $this->model
                ->where(['status' => 1])
                ->field(['id', 'type', 'name as label' , 'value', 'price'])
                ->select();
            // 按 type 分组
            $groupedData = [];
            foreach ($list as $item) {
                // $item['value'] = $item['type'];
                $groupedData[$item['type']][] = $item;
            }
            return $this->success($groupedData);
        }  catch (\Exception $e) {
            return $this->error('系统错误，请稍后再试');
        }
    }




    /**
     * 生成预览图
     */
    /**
     * 生成预览图
     * 
     * @return \think\Response
     */
    public function genPreview()
    {
        try {
            // 获取文件路径或URL
            $filePath = $this->request->input('file_path', '');

            if (empty($filePath)) {
                // 如果没有提供文件路径，尝试获取上传的文件
                $file = $this->request->file('file');
                if ($file) {
                    // 保存上传的文件
                    $savePath = 'public/uploads/';
                    $info = $file->move($savePath);
                    if ($info) {
                        $filePath = $savePath . $info->getSaveName();
                    } else {
                        return $this->error('文件上传失败：' . $file->getError());
                    }
                } else {
                    // 使用示例文件（仅用于测试）
                    $filePath = 'https://mashangyunyin.oss-cn-beijing.aliyuncs.com/uploads/1753067457130_7k1d81g2dj.pdf';
                }
            }

            // 使用DocumentToImage类转换文件为图片
            $document = new DocumentToImage();
            $result = $document->convertToImages($filePath);

            // 返回转换结果
            return $this->success('文件转换成功', $result);
        } catch (\Exception $e) {
            return $this->error('生成预览图失败：' . $e->getMessage());
        }
    }

}
