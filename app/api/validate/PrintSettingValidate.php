<?php

namespace app\api\validate;

use think\Validate;

class PrintSettingValidate extends Validate
{
    protected $rule = [
        'id'        => 'require',
        'options'   => 'require|array'
    ];

    protected $message = [
        'id.require'        => '请输入打印设置ID',
        'options.require'   => '请输入打印设置',
        'options.array'     => '打印设置格式错误'
    ];

    protected $scene = [
        'updatePrintSetting' => ['id','options']
    ];
}