<?php

namespace app\api\controller;

use app\api\validate\CouponTempalteValidate;
use think\exception\ValidateException;
use app\api\model\UserCoupon;
class CouponTemplateController extends BaseController
{
    /**
     * 优惠券验证器
     * @var CouponTempalteValidate
     */
    private CouponTempalteValidate $validate;
    protected $noNeedLogin = [];

    public function __construct()
    {
        parent::__construct();
        $this->validate = new CouponTempalteValidate();
    }

    /**
     * 获取优惠券列表
     */
    public function getCouponList()
    {
        try{

            $params = $this->validate->scene('getCouponList')->failException(true)->checked($this->request->all());

            $list = $this->model->where(['status' => 1])->paginate($params['limit'],$params['page']);

            return $this->success(['list'=>$list->items(),'total'=>$list->total()]);

        }catch(ValidateException $e){

            return $this->error($e->getMessage());
        }
        
    }

    /**
     * 领取优惠券
     */
    public function receiveCoupon()
    {
        try{
            $params = $this->validate->scene('receiveCoupon')->failException(true)->checked($this->request->all());
            //判断优惠券是否存在
            $coupon = $this->model->where(['id'=>$params['coupon_id'],'status'=>1])->find();
            if(!$coupon){
                return $this->error('优惠券不存在');
            }
            //是否领取过
            $userCoupon =   (new UserCoupon())->where(['user_id'=>$this->request->user['id'],'coupon_id'=>$params['coupon_id']])->find();
            if($userCoupon){
                return $this->error('您已经领取过优惠券');
            }
            //领取优惠券
            (new UserCoupon())->create([
                'user_id'       => $this->request->user['id'],
                'coupon_id'     => $params['coupon_id'],
                'amount'        => $coupon['amount'],
                'expire_time'   => date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s').'+'.$coupon['valid_days'].' day')),
            ]);
            return $this->success([],'领取优惠券成功');
        }catch(ValidateException $e){
            return $this->error($e->getMessage());
        }
    }
    
}