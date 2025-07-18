<?php

namespace app\api\model;

use think\Model;

use think\model\concern\SoftDelete;
class PrintSetting extends Model
{
    use SoftDelete;
    protected $name = 'print_setting';

    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $deleteTime = 'delete_time';

    protected $autoWriteTimestamp = 'datetime';
}