<?php

namespace app\api\model;

use think\Model;

class CouponTemplate extends Model
{
    protected $name = 'coupon_template';

    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $deleteTime = false;

    protected $autoWriteTimestamp = 'datetime';

    
}