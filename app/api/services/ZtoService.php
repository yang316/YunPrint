<?php

namespace app\api\services;

include_once __DIR__ . '../../../../vendor/zto/zopsdk-php/ZopClient.php';
include_once __DIR__ . '../../../../vendor/zto/zopsdk-php/ZopProperties.php';
include_once __DIR__ . '../../../../vendor/zto/zopsdk-php/ZopRequest.php';

use zop\ZopClient;
use zop\ZopProperties;
use zop\ZopRequest;

class ZtoService
{
    private $client;
    private $appKey;
    private $appSecret;
    private $baseUrl;

    public function __construct($appKey = '4dd8ab0331ac8b4785cc3', $appSecret = '6600ba18908d597ce18d6020ccfe13df', $isTest = false)
    {
        $this->appKey = $appKey;
        $this->appSecret = $appSecret;

        // 根据环境设置API地址
        if ($isTest) {
            $this->baseUrl = 'https://japi-test.zto.com';
        } else {
            $this->baseUrl = 'https://japi.zto.com';
        }

        $properties = new ZopProperties($this->appKey, $this->appSecret);
        $this->client = new ZopClient($properties);
    }

    /**
     * 绑定电子面单账号
     *
     * @return void
     */
    public function bindingEaccount()
    {
        $request = new ZopRequest();
        $request->setUrl($this->baseUrl . '/zto.open.bindingEaccount');

        // 构建订单数据结构
        $data = [
            'eaccount'          => '114346491', //电子面单账号
            'siteCode'          => '天山一部', //网点code
            'eaccountPwd'       => '', //电子面单密码
        ];

        $request->setData(json_encode($data));

        try {
            $response = $this->client->execute($request);
            return json_decode($response, true);
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => '创建订单失败：' . $e->getMessage()
            ];
        }
    }

    /**
     * 网点信息查询
     *
     * @return void
     */
    public function getBaseOrganizeByFullNameGateway()
    {
        $request = new ZopRequest();
        $request->setUrl($this->baseUrl . '/zto.open.getBaseOrganizeByFullNameGateway');

        // 构建订单数据结构
        $data = [
            'fullName'          => '天山区一部', //
        ];

        $request->setData(json_encode($data));
        try {
            $response = $this->client->execute($request);
            return json_decode($response, true);
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => '查询信息失败' . $e->getMessage()
            ];
        }
    }

    /**
     * 创建订单
     * @param array $orderData 订单数据
     * @return string API响应结果
     */
    public function createOrder()
    {
        $request = new ZopRequest();
        $request->setUrl($this->baseUrl . '/zto.open.createOrder');

        // 构建订单数据结构
        $data = [
            'partnerType'       => '2', //合作模式 ，1：集团客户；2：非集团客户
            'orderType'         => '2', //partnerType为1时，orderType：1：全网件 2：预约件。 partnerType为2时，orderType：1：全网件 2：预约件（返回运单号） 3：预约件（不返回运单号） 4：星联全网件
            'partnerOrderCode'  => 'msyy'.time(), //商家订单号
            'accountInfo'       => [
                'accountId'         => 'test',
                'accountPassword'   => 'ZTO123',
                'type'              =>  '1',
            ],
            'senderInfo'        => [
                // 'senderId'          => '',//发件人ID
                'senderName'        => '测试发件人', //发件人姓名
                'senderMobile'      => '13512341234', //发件人手机号
                'senderProvince'    => '新疆维吾尔自治区', //发件人省份
                'senderCity'        => '乌鲁木齐市', //发件人市
                'senderDistrict'    => '乌鲁木齐区', //发件人区
                'senderAddress'     => '乌鲁木齐市乌鲁木齐区', //发件人详细地址
            ], //发件人信息
            'receiveInfo'       => [
                'receiverName'      => '测试收件人', //收件人姓名
                'receiverMobile'    => '13512341234', //收件人手机号
                'receiverProvince'  => '陕西省', //收件人省份
                'receiverCity'      => '西安市', //收件人市
                'receiverDistrict'  => '雁塔区', //收件人区
                'receiverAddress'   => '电子城街道魔方公寓', //收件人详细地址
            ], //收件人信息
        ];

        $request->setData(json_encode($data));

        try {
            $response = $this->client->execute($request);
            return json_decode($response, true);
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => '创建订单失败：' . $e->getMessage()
            ];
        }
    }

    /**
     * 取消订单
     * @param string $orderId 订单ID
     * @param string $reason 取消原因
     * @return array API响应结果
     */
    public function cancelOrder($orderId, $reason = '用户取消')
    {
        $request = new ZopRequest();
        $request->setUrl($this->baseUrl . '/zto.open.cancelOrder');

        $data = [
            'data' => [
                'content' => [
                    'id' => $orderId,
                    'reason' => $reason
                ],
                'datetime' => date('Y-m-d H:i:s'),
                'partner' => 'test',
                'verify' => 'ZTO123'
            ]
        ];

        $request->setData(json_encode($data));

        try {
            $response = $this->client->execute($request);
            return json_decode($response, true);
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => '取消订单失败：' . $e->getMessage()
            ];
        }
    }

    /**
     * 查询订单
     * @param string $orderId 订单ID
     * @return array API响应结果
     */
    public function queryOrder($orderId)
    {
        $request = new ZopRequest();
        $request->setUrl($this->baseUrl . '/zto.open.queryOrder');

        $data = [
            'data' => [
                'content' => [
                    'id' => $orderId
                ],
                'datetime' => date('Y-m-d H:i:s'),
                'partner' => 'test',
                'verify' => 'ZTO123'
            ]
        ];

        $request->setData(json_encode($data));

        try {
            $response = $this->client->execute($request);
            return json_decode($response, true);
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => '查询订单失败：' . $e->getMessage()
            ];
        }
    }

    /**
     * 查询物流轨迹
     * @param string $trackingNumber 运单号
     * @return array API响应结果
     */
    public function queryTrack($trackingNumber)
    {
        $request = new ZopRequest();
        $request->setUrl($this->baseUrl . '/zto.open.queryTrack');

        $data = [
            'data' => [
                'content' => [
                    'trackingNumber' => $trackingNumber
                ],
                'datetime' => date('Y-m-d H:i:s'),
                'partner' => 'test',
                'verify' => 'ZTO123'
            ]
        ];

        $request->setData(json_encode($data));

        try {
            $response = $this->client->execute($request);
            return json_decode($response, true);
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => '查询物流轨迹失败：' . $e->getMessage()
            ];
        }
    }

    /**
     * 构建标准订单数据结构
     * @param array $senderInfo 发件人信息
     * @param array $receiverInfo 收件人信息
     * @param array $orderInfo 订单信息
     * @return array 标准订单数据
     */
    public function buildOrderData($senderInfo, $receiverInfo, $orderInfo)
    {
        return [
            'id' => $orderInfo['id'] ?? uniqid('zto_'),
            'orderType' => $orderInfo['orderType'] ?? '1',
            'type' => $orderInfo['type'] ?? '1',
            'quantity' => $orderInfo['quantity'] ?? '1',
            'weight' => $orderInfo['weight'] ?? '1.0',
            'size' => $orderInfo['size'] ?? '10,10,10',
            'price' => $orderInfo['price'] ?? '0.00',
            'freight' => $orderInfo['freight'] ?? '10.00',
            'orderSum' => $orderInfo['orderSum'] ?? '0.00',
            'collectSum' => $orderInfo['collectSum'] ?? '0.00',
            'collectMoneytype' => $orderInfo['collectMoneytype'] ?? 'CNY',
            'packCharges' => $orderInfo['packCharges'] ?? '0.00',
            'otherCharges' => $orderInfo['otherCharges'] ?? '0.00',
            'premium' => $orderInfo['premium'] ?? '0.00',
            'remark' => $orderInfo['remark'] ?? '',
            'tradeId' => $orderInfo['tradeId'] ?? '',
            'branchId' => $orderInfo['branchId'] ?? '',
            'buyer' => $orderInfo['buyer'] ?? '',
            'seller' => $orderInfo['seller'] ?? '',
            'typeId' => $orderInfo['typeId'] ?? '',
            'sender' => [
                'id' => $senderInfo['id'] ?? '',
                'name' => $senderInfo['name'],
                'company' => $senderInfo['company'] ?? '',
                'mobile' => $senderInfo['mobile'],
                'phone' => $senderInfo['phone'] ?? '',
                'email' => $senderInfo['email'] ?? '',
                'address' => $senderInfo['address'],
                'city' => $senderInfo['city'],
                'area' => $senderInfo['area'],
                'zipCode' => $senderInfo['zipCode'] ?? '',
                'im' => $senderInfo['im'] ?? '',
                'startTime' => $senderInfo['startTime'] ?? time() * 1000,
                'endTime' => $senderInfo['endTime'] ?? (time() + 86400) * 1000
            ],
            'receiver' => [
                'id' => $receiverInfo['id'] ?? '',
                'name' => $receiverInfo['name'],
                'company' => $receiverInfo['company'] ?? '',
                'mobile' => $receiverInfo['mobile'],
                'phone' => $receiverInfo['phone'] ?? '',
                'email' => $receiverInfo['email'] ?? '',
                'address' => $receiverInfo['address'],
                'city' => $receiverInfo['city'],
                'area' => $receiverInfo['area'],
                'zipCode' => $receiverInfo['zipCode'] ?? '',
                'im' => $receiverInfo['im'] ?? ''
            ]
        ];
    }

    /**
     * 测试方法（保留原有功能）
     */
    public function test()
    {
        $request = new ZopRequest();
        $request->setUrl($this->baseUrl . '/submitOrderCode');
        $request->setData('{"data":{"content":{"branchId":"","buyer":"","collectMoneytype":"CNY","collectSum":"12.00","freight":"10.00","id":"xfs2018031500002222333","orderSum":"0.00","orderType":"1","otherCharges":"0.00","packCharges":"1.00","premium":"0.50","price":"126.50","quantity":"2","receiver":{"address":"育德路XXX号","area":"501022","city":"四川省,XXX,XXXX","company":"XXXX有限公司","email":"yyj@abc.com","id":"130520142097","im":"yangyijia-abc","mobile":"136*****321","name":"XXX","phone":"010-222***89","zipCode":"610012"},"remark":"请勿摔货","seller":"","sender":{"address":"华新镇华志路XXX号","area":"310118","city":"上海,上海市,青浦区","company":"XXXXX有限公司","email":"ll@abc.com","endTime":1369033200000,"id":"131*****010","im":"1924656234","mobile":"1391***5678","name":"XXX","phone":"021-87***321","startTime":1369022400000,"zipCode":"610012"},"size":"12,23,11","tradeId":"2701843","type":"1","typeId":"","weight":"0.753"},"datetime":"2018-3-30 12:00:00","partner":"test","verify":"ZTO123"}}');

        return $this->client->execute($request);
    }
}
