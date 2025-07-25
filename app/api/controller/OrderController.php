<?php

namespace app\api\controller;

use support\think\Db;
use app\api\model\UserAttachment;
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
        $data = $this->request->all();
        
        // 创建订单逻辑
        // 订单数据
        $attachment = UserAttachment::where(['user_id'=>$this->request->user['id']])
            ->whereIn('id',$data['attachment_ids'])
            ->field('id,file_name,url,total,options,copies,selectPage,paperPrice,totalPrice')
            ->select();
        $items = [];//订单详情
        $order = [
            'user_id'       => $this->request->user['id'],//用户ID
            'order_sn'      => generateOrderNo(),//订单编号
            'totalPrice'    => 0,
            'create_time'   => date('Y-m-d H:i:s'),
            'update_time'   => date('Y-m-d H:i:s'),
        ];//订单表
        
        foreach( $attachment as $v){

            $items[] = [
                'fileName'      => $v['file_name'],//文件名称
                'paperPrice'    => $v['paperPrice'],//纸张价格
                'totalPrice'    => $v['totalPrice'],//总价格
                'totalPage'     => $v['selectPage']['end'] - $v['selectPage']['start'] + 1,//打印的页数
                'copies'        => $v['copies'],//份数
                'atta_id'       => $v['id'],//附件ID
                'options'       => json_encode($v['options'], JSON_UNESCAPED_UNICODE),//规格
                'create_time'   => date('Y-m-d H:i:s'),
                'update_time'   => date('Y-m-d H:i:s'),
            ];
            $order['totalPrice'] += $v['totalPrice'];//订单总价
        }
        // 计算产品价格拆分订单详情表
        Db::startTrans();
        try{

            $orderId = $this->model->insertGetId($order);
            foreach ($items as &$item) {
                $item['order_id'] = $orderId;
            }
           \app\api\model\OrderItems::insertAll($items);
            Db::commit();
            return $this->success($orderId);
        }catch(\Exception $e){
            Db::rollback();
            return $this->error($e->getMessage());
        }catch(PDOException $e){
            Db::rollback();
            return $this->error($e->getMessage());
        }

    }

    /**
     * 获取订单列表
     *
     * @return void
     */
    public function getOrderList()
    {
        $where = [];
        //状态筛选
        if( isset( $params['status'] ) && is_numeric( $params['status'] )){
            $where['status'] = $params['status'];
        }
        $list = $this->model->where(['user_id'=>$this->request->user['id']])
            ->with(['orderitems'=>function($query){
                return $query->order('id','desc')->limit(1);
            }])
            ->order('id','desc')
            ->field('id,order_sn,totalPrice,create_time,update_time')
            ->paginate(1,10);
        return $this->success(['list'=>$list->items(),'total'=>$list->items()]);
    }
    
}