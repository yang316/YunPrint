<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: your name
// +----------------------------------------------------------------------
namespace app\backend\CouponTemplate\model;

use plugin\saiadmin\basic\BaseModel;

/**
 * 优惠券模板表模型
 */
class CouponTemplate extends BaseModel
{
    /**
     * 数据表主键
     * @var string
     */
    protected $pk = 'id';

    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $deleteTime = false;
    protected $autoWriteTimestamp = 'datetime';
    /**
     * 数据库表名称
     * @var string
     */
    protected $table = 'sa_coupon_template';

    /**
     * 优惠券标题 搜索
     */
    public function searchTitleAttr($query, $value)
    {
        $query->where('title', 'like', '%'.$value.'%');
    }

    protected $type = [
        'status' => 'int'
    ];

}
