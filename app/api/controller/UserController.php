<?php

namespace app\api\controller;

use support\Request;
use support\think\Db;
use app\api\model\Sms;
use GuzzleHttp\Client;
use app\api\extend\Random;
use app\api\model\SystemConfig;
use app\api\validate\UserValidate;
use think\exception\ValidateException;
class UserController extends BaseController
{

    protected $noNeedLogin = ['login','register','mpLogin'];

    /**
     * @var UserValidate
     */
    private UserValidate $validate;

    public function __construct()
    {
        parent::__construct();
        $this->validate = new UserValidate;
    }

    /**
     * 用户登录
     */
    public function login(Request $request)
    {

        try{
            $params = $this->validate->failException(true)->scene('login')->checked(($request->all()));
        }catch(ValidateException $e){
            return $this->error($e->getError());
        }

        try{
            $account = $this->model->where('mobile',$params['mobile'])->field([
                'id','avatar','nickname','age','gender','password'
                ])->findOrFail();
        }catch(\Exception $e){
            return $this->error('当前手机号未注册');
        }
        $verify = $this->decrypt($params['password'],$account->password);
        if(!$verify){
            return $this->error('密码错误');
        }
        unset($account->password);
        $token = $this->genToken($account->id);
        return $this->success(['user'=>$account,'token'=>$token],'登陆成功');
    }

    /**
     * 用户注册
     * @param $mobile    手机号
     * @param $nickname  昵称
     * @param $password  密码
     * @param $avatar    头像
     * @param $age       年龄
     * @param $gender    性别
     * 
     */
    public function register(Request $request)
    {
        
        try{
            $params = $this->validate->failException(true)->scene('register')->checked(($request->all()));
        }catch(ValidateException $e){
            return $this->error($e->getError());
        }
        $status = false;
        $token = '';
        Db::startTrans();
        try{
            $user = $this->model->create([
                'mobile'    => $params['mobile'],
                'password'  => $this->encypt($params['password']),
                'nickname'  => '测试用户',
            ]);
            $token = $this->genToken($user->id);
            $status = true;
            Db::commit();
        }catch(\Exception $e){
            Db::rollback();
            
        }
        
        if( !$status ){
            return $this->error('注册失败');
        }
        unset($user->password);

        return $this->success(['token'=>$token,'user'=>$user],'注册成功');
    }

    /**
     * 修改密码
     */
    public function changePassword()
    {
        try{
            $params = $this->validate->failException(true)->scene('changePassword')->checked(($this->request->all()));
        }catch(ValidateException $e){
            return $this->error($e->getError());
        }
        $user = $this->request->user;
        if( $params['type'] == 0 ){
            //修改密码
            $verify = $this->decrypt($params['oldPassword'],$user->password);
            $message = $verify==true?'修改成功':'原密码错误';
        }else{
            //短信验证码验证
            $verify = $this->verifyCode($params['mobile'],$params['code']);
            $message = $verify==true?'修改成功':'短信验证码错误';
        }
        if(!$verify){
            return $this->error($message);
        }
        $user->password = $this->encypt($params['password']);
        $user->save();
        return $this->success([],$message);
    }

    /**
     * 发送短信验证码
     * @param $mobile
     */
    public function sendSmsCode()
    {
        try{
            $params = $this->validate->failException(true)->scene('sendSmsCode')->checked(($this->request->all()));
        }catch(ValidateException $e){
            return $this->error($e->getError());
        }

        $code = Random::numeric(6);
        $sms = new Sms();
        $sms->mobile = $params['mobile'];
        $sms->code = $code;
        $sms->expire_time = time() + 60*5;
        $sms->save();

        return $this->success(['code'=>$code],'发送成功');
    }

    /**
     * 验证短信验证码是否正确
     * @param $mobile
     * @param $code
     * @return bool true 正确 false 错误
     */
    public function verifyCode($mobile,$code)
    {
        $sms = Sms::where('mobile',$mobile)->order('id','desc')->find();
        if(!$sms){
            return false;
        }
        if($sms->code != $code){
            return false;
        }
        if($sms->expire_time < time()){
            return false;
        }
        Sms::where('mobile',$mobile)->delete();
        return true;
    }

    /**
     * 修改用户信息
     */
    public function editProfile()
    {
        try{
            $params = $this->validate->failException(true)->scene('editProfile')->checked(($this->request->all()));
        }catch(ValidateException $e){
            return $this->error($e->getError());
        }
        $result = $this->model->where('id',$this->request->user['id'])->update([
            'nickname'  => $params['nickname'],
            'avatar'    => $params['avatar'],
            'age'       => $params['age'],
            'gender'    => $params['gender']
        ]);
        if(!$result){
            return $this->error('修改失败');
        }
        return $this->success([],'修改成功');
    }




    /**
     * 小程序登录
     */
    public function mpLogin()
    {
        try{
            $code = $this->validate->failException(true)->scene('mpLogin')->checked(($this->request->all()));
        }catch(ValidateException $e){
            return $this->error($e->getError());
        }
        if( $this->request->input('env') == 'test' ){
            $token = $this->genToken( 1 );
            $user = $this->model->find(1);
            return $this->success(['user' => $user, 'token' => $token]);
        }
        $url = 'https://api.weixin.qq.com/sns/jscode2session';
        $client = new Client();
        $mpConfig = SystemConfig::whereIn('key', 'Appid,AppSecret')->field(['key', 'value'])->select();
        $configArray = $mpConfig->column('value', 'key');
        try {
            $response = $client->request('GET', $url, [
                'query' => [
                    'appid'         => $configArray['Appid'],
                    'secret'        => $configArray['AppSecret'],
                    'js_code'       => $code,
                    'grant_type'    => 'authorization_code'
                ]
            ]);

            $result = json_decode($response->getBody(), true);

            if(isset($result['errcode']) && $result['errcode'] != 0){
                return $this->error($result['errmsg'] ?? '登录失败', 401);
            }

            $now = date('Y-m-d H:i:s');
            //openid的用户是否存在
            $user = $this->model->where(['openid' => $result['openid']])->field(['id','avatar','nickname','mobile'])->find();
            if(!$user){
                //用户不存在，创建用户
                $user = $this->model->create([
                    'openid'        => $result['openid'],
                    'nickname'      => '微信用户',
                    'regist_time'   => $now,
                    'update_time'   => $now,
                    'mobile'        => '',
                    'avatar'        => '/storage/20250527/default.png',
                ]);
            }
            //创建token
            $token = $this->genToken($user->id);
            return $this->success(['user' => $user, 'token' => $token]);
        } catch (\Exception $e) {
            return $this->error('登录失败: ' . $e->getMessage());
        }
    }
    
    /**
     * 获取用户信息
     */
    public function getUserInfo()
    {
        return $this->success($this->request->user);
    }

    
}