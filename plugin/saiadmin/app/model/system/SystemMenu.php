<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\system;

use plugin\saiadmin\basic\BaseModel;

/**
 * 菜单模型
 */
class SystemMenu extends BaseModel
{
    // 完整数据库表名称
    protected $table  = 'sa_system_menu';
    // 主键
    protected $pk = 'id';

    /**
     * Id搜索
     */
    public function searchIdAttr($query, $value)
    {
        $query->whereIn('id', $value);
    }
	
	/**
     * Type搜索
     */
    public function searchTypeAttr($query, $value)
    {
        if (is_array($value)){
            $query->whereIn('type', $value);
        }else{
            $query->where('type', $value);
        }
    }

}