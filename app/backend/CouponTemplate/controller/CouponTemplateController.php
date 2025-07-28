<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: your name
// +----------------------------------------------------------------------
namespace app\backend\CouponTemplate\controller;

use plugin\saiadmin\basic\BaseController;
use app\backend\CouponTemplate\logic\CouponTemplateLogic;
use app\backend\CouponTemplate\validate\CouponTemplateValidate;
use support\Request;
use support\Response;

/**
 * 优惠券模板表控制器
 */
class CouponTemplateController extends BaseController
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->logic = new CouponTemplateLogic();
        $this->validate = new CouponTemplateValidate;
        parent::__construct();
    }

    /**
     * 数据列表
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $where = $request->more([
            ['title', ''],
            ['type', ''],
        ]);
        $query = $this->logic->search($where);
        $data = $this->logic->getList($query);
        return $this->success($data);
    }

}
