<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\system;

use plugin\saiadmin\basic\BaseModel;

/**
 * 字典数据模型
 */
class SystemDictData extends BaseModel
{
    /**
     * 数据表主键
     * @var string
     */
    protected $pk = 'id';

    protected $table = 'sa_system_dict_data';

    /**
     * 关键字搜索
     */
    public function searchKeywordsAttr($query, $value)
    {
        $query->where('label|code', 'LIKE', "%$value%");
    }
}