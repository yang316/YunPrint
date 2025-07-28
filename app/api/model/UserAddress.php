<?php

namespace app\api\model;

use think\Model;

class UserAddress extends Model
{
    protected $name = 'user_address';


    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $deleteTime = false;
    protected $autoWriteTimestamp = 'datetime';

    // 定义字段类型
    protected $type = [
        'region' => 'array'
    ];
}