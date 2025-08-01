<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\system;

use plugin\saiadmin\basic\BaseModel;

/**
 * 邮件记录模型
 */
class SystemMail extends BaseModel
{
    /**
     * 数据表主键
     * @var string
     */
    protected $pk = 'id';

    protected $table = 'sa_system_mail';

    public function searchFromAttr($query, $value)
    {
        $query->where('from', 'like', '%' . $value . '%');
    }

    public function searchEmailAttr($query, $value)
    {
        $query->where('email', 'like', '%' . $value . '%');
    }
}