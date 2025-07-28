<?php

namespace app\api\validate;

use think\Validate;

class OrderValidate extends Validate
{
    protected $rule = [
        'page'          => 'require|integer',
        'limit'         => 'require|integer',
        'status'        => 'require|integer',
        'consignee'     => 'require',
        'mobile'        => 'require|mobile',
        'region'        => 'require|array:province,city,district',
        'is_default'    => 'require|in:0,1',
        'id'            => 'require|integer',
        'attachment_ids'=> 'require|array',
        'coupon_id'     => 'integer',
        'address_id'    => 'require|integer',
    ];

    protected $message = [
        'page.require'        => 'page参数不能为空',
        'limit.require'       => 'limit参数不能为空',
        'status.require'      => 'status参数不能为空',
        'consignee.require'   => '收货人不能为空',
        'mobile.require'      => '手机号不能为空',
        'mobile.mobile'       => '手机号格式错误',
        'region.require'      => '请选择省份、城市、区县',
        'is_default.require'  => '请选择是否设为默认地址',
        'is_default.in'       => 'is_default参数必须为0或1',    
        'region.array'        => 'region参数必须为数组',
        'region.province'     => '请选择省份',
        'region.city'         => '请选择城市',
        'region.district'     => '请选择区县',
        'id.require'          => 'id参数不能为空',
        'id.integer'          => 'id参数必须为整数',
        'attachment_ids.require'    => '请选择文件',
        'attachment_ids.array'      => 'attachment_ids参数必须为数组',
        'coupon_id.integer'         => 'coupon_id参数必须为整数',
        'address_id.require'        => '请选择地址',
        'address_id.integer'        => 'address_id参数必须为整数',
    
    ];

    // 定义场景
    protected $scene = [
        'list'              => ['page', 'limit', 'status'],
        'detail'            => ['id'],
        'addAddress'        => ['consignee', 'mobile', 'region', 'is_default'],
        'editAddress'       => ['id', 'consignee', 'mobile', 'region', 'is_default'],
        'delAddress'        => ['id'],
        'getAddressList'    => ['page', 'limit'],
        'getAddressDetail'  => ['id'],
        'createOrder'       => ['address_id','attachment_ids'],
        'calc'              => ['attachment_ids','coupon_id','address_id'],
    ];
}