<?php

namespace app\api\model;

use think\Model;

class Order extends Model
{
    protected $name = 'order';

    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $deleteTime = false;

    protected $autoWriteTimestamp = 'datetime';


    public function orderitems()
    {
        return $this->hasMany(OrderItems::class,'order_id','id');
    }
    
}