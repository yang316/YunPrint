<?php

namespace app\api\controller;

use app\api\model\Token;
class BaseController
{
    /**
     * 无需登录的方法
     */
    protected $noNeedLogin = [];

    public $model = null;
    public $request = null;

    public function __construct()
    {
         // 获取当前控制器名称
         $controllerName = request()->controller;
         
        // 从控制器名称中提取模型名称
        if ($controllerName) {
            // 获取类名（不含命名空间）
            $className = (new \ReflectionClass($controllerName))->getShortName();
            // 移除Controller后缀
            $modelName = str_replace('Controller', '', $className);
            // 构建模型的完整命名空间
            $modelClass = "\\app\\api\\model\\{$modelName}";

            // 检查模型类是否存在，如果存在则实例化
            if (class_exists($modelClass)) {
                try {
                    $this->model = new $modelClass();
                } catch (\Exception $e) {
                    // 记录错误但不中断执行
                    // 可以添加日志记录
                    var_dump("模型实例化失败: " . $e->getMessage());
                }
            }
        }
        $this->request = request();
    }

    /**
     * @param $code
     * @param $msg
     * @param $data
     * @param $status
     * @param $headers
     */
    public function response($code = 200, $msg = '', $data = [],$status=200,$headers=[])
    {
        return json(['code'=>$code,'message'=>$msg,'data'=>$data],$status,$headers);
    }


    /**
     * @param $data
     * @param $msg
     * @param $code
     * @param $status
     * @param $headers
     */
    public function success($data=[],$msg='success',$code=200)
    {
        return json(['code'=>$code,'message'=>$msg,'data'=>$data],JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param $data
     * @param $msg
     * @param $code
     * @param $status
     * @param $headers
     */
    public function error($msg='操作失败',$data=[],$code=400)
    {
        return json(['code'=>$code,'message'=>$msg,'data'=>$data],JSON_UNESCAPED_UNICODE);
    }

    /**
     * 加密密码
     * @param $password
     * @return string
     */
    public function encypt($password)
    {
        return password_hash($password, PASSWORD_ARGON2ID);
    }

    /**
     * 验证密码
     * @param $inputPassword
     * @param $hashPassword
     * @return bool
     */
    public function decrypt($inputPassword,$hashPassword)
    {
        return password_verify($inputPassword, $hashPassword);
    }


    /**
     * 生成token
     * @param $user_id
     * @return string
     */
    public function genToken($user_id)
    {
        return (new Token)->createToken($user_id);
    }


    
}