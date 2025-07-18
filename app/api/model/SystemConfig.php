<?php

namespace app\api\model;

use think\Model;

use think\model\concern\SoftDelete;
class SystemConfig extends  Model
{
    use SoftDelete;
    protected $name = 'system_config';

    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $deleteTime = 'delete_time';

    protected $autoWriteTimestamp = 'datetime';


}