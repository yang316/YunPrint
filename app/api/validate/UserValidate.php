<?php

namespace app\api\validate;

use app\api\model\User;
use think\Validate;

class UserValidate extends Validate
{
    protected $rule = [
        'mobile'            => 'require|uniqueUser|isExist',
        'password'          => 'require|length:6,20',
        'type'              => 'require|in:0,1',
        'oldPassword'       => 'require|length:6,20',
        'nickname'          =>'require|length:2,10',
        'age'               =>'require|number|between:1,120',
        'gender'            =>'require|in:0,1,2',
        'avatar'            =>'require',
    ];

    protected $message = [
        'mobile.require'    => '手机号不能为空',
        'mobile.uniqueUser' => '手机号已被注册',
        'mobile.isExist'    => '手机号未注册',
        'password.require'  => '密码不能为空',
        'password.length'   => '密码长度为6-20位',
        'type.require'      => '类型不能为空',
        'type.in'           => '类型参数不正确',
        'oldPassword.require'  => '原密码不能为空',
        'oldPassword.length'   => '原密码长度为6-20位',
        'nickname.require'  => '昵称不能为空',
        'nickname.length'   => '昵称长度为2-10位',
        'age.require'       => '年龄不能为空',
        'age.number'        => '年龄必须为数字',
        'age.between'       => '年龄范围为1-120岁',
        'gender.require'    => '性别不能为空',  
        'gender.in'         => '性别参数不正确',
        'avatar.require'    => '头像不能为空',
    ];

    protected $scene = [
        'register'          => ['mobile','password'],
        'changePassword'    => ['mobile','type','oldPassword','password'],
        'editProfile'       => ['nickname','age','gender','avatar'],
    ];

    // 自定义验证规则
    protected function uniqueUser($value,$rule,$data)
    {
        $user = User::where('mobile',$value)->find();
        if($user){
            return false;
        }else{
            return true;
        }
    }

    // 自定义验证规则
    protected function isExist($value,$rule,$data)
    {
        $user = User::where('mobile',$value)->find();

        if($user){

            return true;

        }else{

            return false;

        }
    }
    // 自定义验证场景
    public function sceneLogin()
    {
        return $this->only(['mobile','password'])->remove('mobile', 'uniqueUser');
    }

    public function sceneSendSmsCode()
    {
        return $this->only(['mobile'])->remove('mobile','uniqueUser');
    }
}