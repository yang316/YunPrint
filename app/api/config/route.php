<?php
use Webman\Route;
use app\api\controller\UserController;
use app\api\controller\PrintSettingController;
use app\api\controller\UserAttachmentController;
use app\api\controller\UploadController;
use app\api\controller\DocumentController;
use app\api\controller\OrderController;
use app\api\controller\CouponTemplateController;
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
       
    });
    
    //用户附件设置
    Route::group('/userAttachment',function (){
        //待打印列表
        Route::get('/getWaitPrintList',[UserAttachmentController::class,'waitPrintList']);
         //更新打印设置
        Route::put('/updatePrintSetting',[UserAttachmentController::class,'updatePrintSetting']);
        //获取预览图
        Route::get('/getPreview',[UserAttachmentController::class,'getPreview']);
        //删除文件
        Route::delete('/deleteAttachment',[UserAttachmentController::class,'deleteAttachment']);
    });
    //通用接口
    Route::group('/common',function(){
        //分片上传文件
        Route::post('/upload', [UploadController::class, 'upload']);
        //获取页数测试
        Route::get('/getPdfPages', [DocumentController::class, 'getPdfPages']);
    });
    
    // 文档处理
    Route::group('/document', function() {
        // 合并PDF文件
        Route::post('/mergeDocuments', [DocumentController::class, 'mergeDocuments']);
        // 合并Word文档
        Route::post('/mergeWord', [DocumentController::class, 'mergeWord']);
        // 获取系统信息
        Route::get('/systemInfo', [DocumentController::class, 'systemInfo']);
    });
    
    Route::group('/order',function (){
        // 创建订单
        Route::post('/preCalcOrder', [OrderController::class, 'preCalcOrder']);
        //获取订单列表
        Route::get('/getOrderList',[OrderController::class,'getOrderList']);
        //添加地址
        Route::post('/addAddress',[OrderController::class,'addAddress']);
        //修改地址
        Route::put('/editAddress',[OrderController::class,'addAddress']);
        //获取地址列表
        Route::get('/getAddressList',[OrderController::class,'getAddressList']);
        //删除地址
        Route::delete('/delAddress',[OrderController::class,'delAddress']);
    });
    //优惠券
    Route::group('/coupon',function (){
        //获取优惠券列表
        Route::get('/getCouponList',[CouponTemplateController::class,'getCouponList']);
        //领取优惠券
        Route::post('/receiveCoupon',[CouponTemplateController::class,'receiveCoupon']);
    });

    Route::group('/test',function (){
        //测试
        // Route::get('/addPrintList1',[UploadController::class,'addPrintList1']);
    });
})->middleware([
    \app\api\middleware\Authorize::class,
    \app\api\middleware\AccessControl::class
]);



Route::disableDefaultRoute('','api');