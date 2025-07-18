<?php

namespace app\api\controller;

use app\api\validate\PrintSettingValidate;
use think\exception\ValidateException;
use app\api\extends\DocumentToImage;
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
            $params = $this->validate->failException(true)
                ->scene('getPrintSetting')
                ->check($this->request->all());

            $where = [
                ['status', '=', 1],
            ];
            // 查询并分组
            $list = $this->model
                ->where($where)
                ->field(['id', 'type', 'name', 'value', 'price',''])
                ->select();
            // 按 type 分组
            $groupedData = [];
            foreach ($list as $item) {
                $groupedData[$item['type']][] = $item;
            }
            return $this->success( $groupedData );
        } catch (ValidateException $e) {
            return $this->error($e->getError());
        } catch (\Exception $e) {
            return $this->error('系统错误，请稍后再试');
        }
    }

    /**
     * 生成预览图
     */
    public function genPreview()
    {
        //pdf\docx生成预览图
//        $file = $this->request->file('file');
        $file = (new DocumentToImage)->convertToImages('public/uploads/众联加油小程序端操作文档(1).docx');
        d($file);
    }



}