<?php

namespace app\api\validate;

use think\Validate;

class CouponTempalteValidate extends Validate
{
    protected $rule = [
        'page' => 'require|integer',
        'limit' => 'require|integer',
        'coupon_id' => 'require|integer',
    ];

    protected $message = [
        'page.require' => 'page参数必须填写',
        'limit.require' => 'limit参数必须填写',
        'page.integer' => 'page参数必须是整数',
        'limit.integer' => 'limit参数必须是整数',
        'coupon_id.require' => 'coupon_id参数必须填写',
        'coupon_id.integer' => 'coupon_id参数必须是整数',
    ];

    // 定义场景
    protected $scene = [
        'getCouponList' => ['page','limit'],
        'receiveCoupon' => ['coupon_id'],
    ];
}