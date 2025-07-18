<?php

namespace app\api\model;

use think\Model;
use think\model\concern\SoftDelete;

class User extends Model
{
    use SoftDelete;

    protected $name = 'user';

    protected $createTime = 'regist_time';
    protected $updateTime = 'update_time';
    protected $deleteTime = 'delete_time';

    protected $autoWriteTimestamp = true;


    public function getAvatarAttr($value)
    {
        return $value ? config('app.upload_url').$value : '';
    }
}
