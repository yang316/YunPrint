<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: your name
// +----------------------------------------------------------------------
namespace app\backend\printSetting\validate;

use think\Validate;

/**
 * 打印设置验证器
 */
class PrintSettingValidate extends Validate
{
    /**
     * 定义验证规则
     */
    protected $rule =   [
        'type' => 'require',
        'name' => 'require',
        'value' => 'require',
        'price' => 'require',
        'sort' => 'require',
        'is_default' => 'require',
        'status' => 'require',
    ];

    /**
     * 定义错误信息
     */
    protected $message  =   [
        'type' => '选项类型必须填写',
        'name' => '选项名称必须填写',
        'value' => '选项值必须填写',
        'price' => '价格必须填写',
        'sort' => '排序必须填写',
        'is_default' => '是否默认必须填写',
        'status' => '状态必须填写',
    ];

    /**
     * 定义场景
     */
    protected $scene = [
        'save' => [
            'type',
            'name',
            'value',
            'price',
            'sort',
            'is_default',
            'status',
        ],
        'update' => [
            'type',
            'name',
            'value',
            'price',
            'sort',
            'is_default',
            'status',
        ],
    ];

}
