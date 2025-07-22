<?php

namespace app\api\model;

use think\Model;

class UserAttachment extends Model
{
    protected $name = 'user_attachment';


    protected $createTime = 'create_time';
    protected $updateTime = false;
    protected $deleteTime = false;
    protected $autoWriteTimestamp = 'datetime';

    // 定义字段类型
    protected $type = [
        'options'       => 'array',
        'select_page'   => 'array'
    ];
}