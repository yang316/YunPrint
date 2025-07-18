<?php

// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\system;

use plugin\saiadmin\basic\BaseModel;

/**
 * 登录日志模型
 */
class SystemLoginLog extends BaseModel
{
    /**
     * 数据表主键
     * @var string
     */
    protected $pk = 'id';

    protected $table = 'sa_system_login_log';

    /**
     * 时间范围搜索
     */
    public function searchLoginTimeAttr($query, $value)
    {
        $query->whereTime('login_time', 'between', $value);
    }

}