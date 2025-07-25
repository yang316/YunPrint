<?php

namespace app\api\model;

use think\Model;

class OrderItems extends Model
{
    protected $name = 'order_items';

    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $deleteTime = false;

    protected $autoWriteTimestamp = 'datetime';

    protected $type = [
        'options'   => 'array',
    ];

    
}