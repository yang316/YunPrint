<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: your name
// +----------------------------------------------------------------------
namespace app\backend\CouponTemplate\validate;

use think\Validate;

/**
 * 优惠券模板表验证器
 */
class CouponTemplateValidate extends Validate
{
    /**
     * 定义验证规则
     */
    protected $rule =   [
        'title' => 'require',
        'type' => 'require',
        'amount' => 'require',
        'min_amount' => 'require',
        'valid_days' => 'require',
        'status'    => 'require',
        // 'created_time' => 'require',
        // 'updated_time' => 'require',
    ];

    /**
     * 定义错误信息
     */
    protected $message  =   [
        'title' => '优惠券标题必须填写',
        'type' => '优惠券类型必须填写',
        'amount' => '优惠金额必须填写',
        'min_amount' => '满减门槛金额必须填写',
        'valid_days' => '有效天数必须填写',
        'status'    => '状态必须选择',
        // 'created_time' => '创建时间必须填写',
        // 'updated_time' => '更新时间必须填写',
    ];

    /**
     * 定义场景
     */
    protected $scene = [
        'save' => [
            'title',
            'type',
            'amount',
            'min_amount',
            'valid_days',
            'status',
            // 'created_time',
            // 'updated_time',
        ],
        'update' => [
            'title',
            'type',
            'amount',
            'min_amount',
            'valid_days',
            'status',
            // 'created_time',
            // 'updated_time',
        ],
    ];

}
