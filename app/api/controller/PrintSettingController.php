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


}
