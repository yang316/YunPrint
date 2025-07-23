<?php
use Webman\Route;
use app\api\controller\UserController;
use app\api\controller\PrintSettingController;
use app\api\controller\UserAttachmentController;
use app\api\controller\UploadController;
use app\api\controller\DocumentController;
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
        //小程序
        Route::post('/mpLogin',[UserController::class,'mpLogin']);
    });

    //打印设置
    Route::group('/printSetting',function (){
        //获取打印设置
        Route::get('/getPrintSetting',[PrintSettingController::class,'getPrintSetting']);
        //生成预览
        Route::get('/genPreview',[PrintSettingController::class,'genPreview']);
       
    });
    
    //用户附件设置
    Route::group('/userAttachment',function (){
        //待打印列表
        Route::get('/getWaitPrintList',[UserAttachmentController::class,'waitPrintList']);
         //更新打印设置
        Route::put('/updatePrintSetting',[UserAttachmentController::class,'updatePrintSetting']);
    });

    Route::group('/common',function(){
        Route::post('/upload', [UploadController::class, 'upload']);
        //获取页数测试
        Route::get('/getPdfPages', [DocumentController::class, 'getPdfPages']);
    });
    
    // 文档处理
    Route::group('/document', function() {
        // 文档转图片
        Route::post('/convertToImages', [DocumentController::class, 'convertToImages']);
        // 合并PDF文件
        Route::post('/mergeDocuments', [DocumentController::class, 'mergeDocuments']);
        // 合并Word文档
        Route::post('/mergeWord', [DocumentController::class, 'mergeWord']);
        // 获取系统信息
        Route::get('/systemInfo', [DocumentController::class, 'systemInfo']);
    });
    

})->middleware([
    \app\api\middleware\Authorize::class,
    \app\api\middleware\AccessControl::class
]);



Route::disableDefaultRoute('','api');