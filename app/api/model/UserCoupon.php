<?php

namespace app\api\model;

use think\Model;

class UserCoupon extends Model
{
    protected $name = 'user_coupon';

    protected $createTime = 'create_time';
    protected $updateTime = false;
    protected $deleteTime = false;

    protected $autoWriteTimestamp = 'datetime';

    
}