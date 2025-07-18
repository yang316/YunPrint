<?php

namespace app\api\middleware;

use Webman\Http\Request;
use Webman\Http\Response;
use Webman\MiddlewareInterface;
use ReflectionClass;
use app\api\model\Token;

class Authorize implements MiddlewareInterface
{
    public function process(Request $request, callable $handler): Response
    {
        // Access to files beginning with. Is prohibited
        if (strpos($request->path(), '/.') !== false) {
            return response('<h1>403 forbidden</h1>', 403);
        }

        // 获取控制器和方法
        $controllerName = $request->controller;
        $action = $request->action;
        if (class_exists($controllerName)) {
            $ref = new ReflectionClass($controllerName);
            $noNeedLogin = $ref->getDefaultProperties()['noNeedLogin'] ?? [];
            if (in_array($action, $noNeedLogin)) {
                // 无需登录
                return $handler($request);
            }
        }

        // 需要登录，检查token
        $token = $request->header('token');
        if (!$token) {
            return json(['code'=>401, 'msg'=>'请先登录']);
        }
        // 查询用户信息
        $user = Token::where('token', $token)->with(['user'=>function($query){
            $query->field(['id','nickname','avatar','mobile','gender','age']);
        }])->find();
        
        // 检查用户信息
        if ( !$user || !$user?->user ) {
            return json(['code'=>401, 'msg'=>'token无效或已过期']);
        }
        // 检查过期状态
        if( strtotime($user->expire_time) < time() ){
            return json(['code'=>401, 'msg'=>'身份信息已过期,请重新登录']);
        }
        // 注入用户信息到request（可自定义属性名）
        $request->user = [
            'id'        => $user->user['id'],
            'nickname'  => $user->user['nickname'],
            'avatar'    => $user->user['avatar'],
            'mobile'    => $user->user['mobile'],
            'gender'    => $user->user['gender'],
            'age'       => $user->user['age']
        ];
        /** @var Response $response */
        $response = $handler($request);
       
        return $response;
    }
}
