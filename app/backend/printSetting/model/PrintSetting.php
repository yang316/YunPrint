<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: your name
// +----------------------------------------------------------------------
namespace app\backend\printSetting\model;

use plugin\saiadmin\basic\BaseModel;

/**
 * 打印设置模型
 */
class PrintSetting extends BaseModel
{
    /**
     * 数据表主键
     * @var string
     */
    protected $pk = 'id';

    /**
     * 数据库表名称
     * @var string
     */
    protected $table = 'sa_print_setting';

    /**
     * 选项名称 搜索
     */
    public function searchNameAttr($query, $value)
    {
        $query->where('name', 'like', '%'.$value.'%');
    }

    /**
     * 创建时间 搜索
     */
    public function searchCreateTimeAttr($query, $value)
    {
        $query->whereTime('create_time', 'between', $value);
    }

}
