<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: your name
// +----------------------------------------------------------------------
namespace app\backend\printSetting\logic;

use app\backend\printSetting\model\PrintSetting;
use plugin\saiadmin\basic\BaseLogic;

/**
 * 打印设置逻辑层
 */
class PrintSettingLogic extends BaseLogic
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->model = new PrintSetting();
    }

}
