<?php

namespace app\api\controller;

use support\think\Db;
use app\api\model\UserAttachment;
use app\api\model\UserAddress;
use app\api\validate\OrderValidate;
use think\db\exception\PDOException;

/**
 * 订单处理控制器
 * 提供PDF和Word文档的处理功能
 */
class OrderController extends BaseController
{
    protected $noNeedLogin = [];

    /**
     * @var OrderValidate
     */
    protected OrderValidate $validate;

    public function __construct()
    {
        parent::__construct();
        $this->validate = new OrderValidate();
    }


    /**
     * 创建订单
     */
    public function createOrder()
    {
        Db::startTrans();
        try {
            $data = $this->validate->scene('create')->failException(true)->checked($this->request->all());

            // 创建订单逻辑
            // 订单数据
            $attachment = UserAttachment::where(['user_id' => $this->request->user['id']])
                ->whereIn('id', $data['attachment_ids'])
                ->field('id,file_name,url,total,options,copies,selectPage,paperPrice,totalPrice')
                ->select();
            $items = []; //订单详情
            $order = [
                'user_id'       => $this->request->user['id'], //用户ID
                'order_sn'      => generateOrderNo(), //订单编号
                'totalPrice'    => 0,
                'create_time'   => date('Y-m-d H:i:s'),
                'update_time'   => date('Y-m-d H:i:s'),
            ]; //订单表

            foreach ($attachment as $v) {

                $items[] = [
                    'fileName'      => $v['file_name'], //文件名称
                    'paperPrice'    => $v['paperPrice'], //纸张价格
                    'totalPrice'    => $v['totalPrice'], //总价格
                    'totalPage'     => $v['selectPage']['end'] - $v['selectPage']['start'] + 1, //打印的页数
                    'copies'        => $v['copies'], //份数
                    'atta_id'       => $v['id'], //附件ID
                    'options'       => json_encode($v['options'], JSON_UNESCAPED_UNICODE), //规格
                    'create_time'   => date('Y-m-d H:i:s'),
                    'update_time'   => date('Y-m-d H:i:s'),
                ];
                $order['totalPrice'] += $v['totalPrice']; //订单总价
            }
            // 计算产品价格拆分订单详情表
            $orderId = $this->model->insertGetId($order);
            foreach ($items as &$item) {
                $item['order_id'] = $orderId;
            }
            \app\api\model\OrderItems::insertAll($items);
            Db::commit();
            return $this->success(['orderId' => $orderId]);
        } catch (\Exception $e) {
            Db::rollback();
            return $this->error($e->getMessage());
        } catch (PDOException $e) {
            Db::rollback();
            return $this->error($e->getMessage());
        } catch (\Exception $e) {
            Db::rollback();
            return $this->error($e->getMessage());
        }
    }




    /**
     * 获取订单列表
     */
    public function getOrderList()
    {
        try {
            $params = $this->validate->scene('list')->failException(true)->checked($this->request->all());
            $where = [];
            //状态筛选
            if (isset($params['status']) && is_numeric($params['status'])) {
                $where['status'] = $params['status'];
            }
            $list = $this->model->where(['user_id' => $this->request->user['id']])
                ->with(['orderitems' => function ($query) {
                    return $query->order('id', 'desc')->limit(1);
                }])
                ->order('id', 'desc')
                ->field('id,order_sn,totalPrice,create_time,update_time')
                ->paginate($params['page'], $params['limit']);
            return $this->success(['list' => $list->items(), 'total' => $list->items()]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }


    /**
     * 添加地址
     */
    public function addAddress()
    {
        try {
            $isPost = $this->request->isPost();
            $scene = $isPost ? 'addAddress' : 'editAddress';

            $params = $this->validate->scene($scene)->failException(true)->checked($this->request->all());
            $userId = $this->request->user['id'];

            // 处理默认地址逻辑（添加或修改时都需要）
            if (isset($params['is_default']) && $params['is_default'] == 1) {
                UserAddress::where(['user_id' => $userId, 'is_default' => 1])
                    ->update(['is_default' => 0]);
            }

            if ($isPost) {
                // 添加地址
                $params['user_id'] = $userId;
                $address = new UserAddress();
                $address->save($params);
                return $this->success(['id' => $address->id]);
            } else {
                // 修改地址
                $address = UserAddress::where(['user_id' => $userId, 'id' => $params['id']])->find();
                if (!$address) {
                    return $this->error('地址不存在');
                }
                $address->save($params);
                return $this->success([], '修改成功');
            }
        } catch (\Exception $e) {
            // 可以根据具体异常类型添加更详细的处理
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取地址列表
     */
    public function getAddressList()
    {
        try {
            $params = $this->validate->scene('getAddressList')->failException(true)->checked($this->request->all());
            $list = UserAddress::where(['user_id' => $this->request->user['id']])
                ->order('id', 'desc')
                ->field('id,mobile,consignee,region,is_default,create_time,update_time')
                ->paginate($params['limit'],$params['page']);
            return $this->success(['list' => $list->items(), 'total' => $list->total()]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取地址详情
     */
    public function getAddressDetail()
    {
        try {
            $params = $this->validate->scene('getAddressDetail')->failException(true)->checked($this->request->all());
            $address = UserAddress::where(['user_id' => $this->request->user['id'], 'id' => $params['id']])
                ->field('id,name,phone,region,is_default,create_time,update_time')
                ->find();
            if (!$address) {
                return $this->error('地址不存在');
            }
            return $this->success(['address' => $address]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }



    /**
     * 删除地址
     */
    public function delAddress()
    {
        try {
            $params = $this->validate->scene('delAddress')->failException(true)->checked($this->request->all());
            $address = UserAddress::where(['user_id' => $this->request->user['id'], 'id' => $params['id']])
                ->find();
            if (!$address) {
                return $this->error('地址不存在');
            }
            $address->delete();
            return $this->success([], '删除成功');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 计算订单价格并返回订单数据
     */
    public function preCalcOrder()
    {
        try {
            $data = $this->validate->scene('calc')->failException(true)->checked($this->request->all());
            $order = $this->calcOrderPrice($data['attachment_ids'],$data['coupon_id']);
            // Db::commit();
            return $this->success($order);
        }catch(\Exception $e){

            return $this->error($e->getMessage());
        }
    }

    /**
     * 计算订单价格
     *
     * @param [type] $attachment_ids 附件id
     * @param integer $coupon_id     优惠券ID
     * @return array
     */
    private function calcOrderPrice( $attachment_ids,$address_id=0,$coupon_id = 0  )
    {

            // 创建订单逻辑
            // 订单数据
            $attachment = UserAttachment::where(['user_id' => $this->request->user['id']])
                ->whereIn('id', $attachment_ids)
                ->field('id,file_name,url,total,options,copies,selectPage,paperPrice,totalPrice')
                ->select();
            $items = []; 
            //订单
            $order = [
                'user_id'       => $this->request->user['id'], //用户ID
                'order_sn'      => generateOrderNo(), //订单编号
                'totalPrice'    => 0,
                'create_time'   => date('Y-m-d H:i:s'),
                'update_time'   => date('Y-m-d H:i:s'),
                'couponPrice'   => 0,
            ];
             //订单详情
            foreach ($attachment as $v) {

                $items[] = [
                    'fileName'      => $v['file_name'], //文件名称
                    'paperPrice'    => $v['paperPrice'], //纸张价格
                    'totalPrice'    => $v['totalPrice'], //总价格
                    'totalPage'     => $v['selectPage']['end'] - $v['selectPage']['start'] + 1, //打印的页数
                    'copies'        => $v['copies'], //份数
                    'atta_id'       => $v['id'], //附件ID
                    'options'       => $v['options'], //规格
                    'create_time'   => date('Y-m-d H:i:s'),
                    'update_time'   => date('Y-m-d H:i:s'),
                ];
                $order['totalPrice'] += $v['totalPrice']; //订单总价
            }
            //邮费计算
            if( $address_id ){
                //邮费计算
                $order['postage'] = $this->postPrice($address_id,$order['totalPrice']);
                $order['totalPrice'] = round($order['totalPrice'] + $order['postage'],2);
            } 
            //优惠券计算
            if( $coupon_id ){
                $order['couponPrice'] = $this->postPrice($address_id,$order['totalPrice']);
                $order['totalPrice'] = round($order['totalPrice'] - $order['couponPrice'],2);
            }
            
            $order['item'] = $items;
            return $order;
    }


    /**
     * 邮费计算
     */
    public function postPrice($address_id,$price )
    {
        //满20新疆全疆包邮 小于20运费8元
        $address = UserAddress::where(['id'=>$address_id])->find();
        if( !$address ){
           return 0;
        }
        
        if( $address['region']['province'] == '新疆维吾尔自治区' ){
            if( $price >=20 ){
                return 0;
            }else{
                return 8;
            }
        }else{
            return 20;
        }
    }

    /**
     * 优惠券金额计算
     */
    public function couponPrice($coupon_id,$price)
    {
        //判断优惠券是否存在
        $coupon = \app\api\model\UserCoupon::alias('uc')
            ->join('coupon_template ct','ct.id = uc.coupon_id','left')
            ->where([
                'uc.user_id'   => $this->request->user['id'],
                'uc.id'        => $coupon_id,
                'uc.status'    => 1,
            ])
            ->field(['uc.amount','ct.min_amount','uc.expire_time','uc.status'])
            ->find();
        if( $coupon['status'] != 1 ){
           throw new \Exception('优惠券不存在');
        }
        if( $price < $coupon['min_amount'] ){
            throw new \Exception('订单金额不足');
        }
        if( $coupon['expire_time'] < time() ){
            throw new \Exception('优惠券已过期');
        }

    }
}




