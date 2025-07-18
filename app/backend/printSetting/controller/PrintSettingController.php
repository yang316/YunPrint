<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: your name
// +----------------------------------------------------------------------
namespace app\backend\printSetting\controller;

use app\backend\printSetting\logic\PrintSettingLogic;
use app\backend\printSetting\validate\PrintSettingValidate;
use plugin\saiadmin\basic\BaseController;
use support\Request;
use support\Response;

/**
 * 打印设置控制器
 */
class PrintSettingController extends BaseController
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->logic = new PrintSettingLogic();
        $this->validate = new PrintSettingValidate;
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
            ['type', ''],
            ['name', ''],
            ['create_time', ''],
        ]);
        $query = $this->logic->search($where);
        $data = $this->logic->getList($query);
        return $this->success($data);
    }



}
