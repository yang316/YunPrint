<?php

namespace app\api\model;

use think\Model;

class Sms extends Model
{
    protected $name = 'sms';

    protected $createTime = 'create_time';
    protected $updateTime = false;
    protected $deleteTime = false;

    protected $autoWriteTimestamp = true;

    
}