<?php
use Webman\Route;
use app\api\controller\UserController;

Route::group('/api', function () {

    //用户接口
    Route::group('/user',function (){
        //登录
        Route::post('/login',[UserController::class,'login']);
        //注册
        Route::post('/register',[UserController::class,'register']);
        //用户信息
        Route::get('/info',[UserController::class,'getUserInfo']);
        //获取短信验证码
        Route::get('/sendSms',[UserController::class,'sendSmsCode']);
        //修改密码
        Route::put('/changePassword',[UserController::class,'changePassword']);
        //修改用户信息
        Route::put('/editProfile',[UserController::class,'editProfile']);
    });

})->middleware([\app\api\middleware\Authorize::class]);


Route::disableDefaultRoute('','api');