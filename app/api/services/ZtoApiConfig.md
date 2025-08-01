# 中通快递API配置说明

## API地址配置

### 测试环境
- **地址**: `https://japi-test.zto.com`
- **创建订单**: `https://japi-test.zto.com/zto.open.createOrder`
- **取消订单**: `https://japi-test.zto.com/zto.open.cancelOrder`
- **查询订单**: `https://japi-test.zto.com/zto.open.queryOrder`
- **查询轨迹**: `https://japi-test.zto.com/zto.open.queryTrack`

### 正式环境
- **地址**: `https://japi.zto.com`
- **创建订单**: `https://japi.zto.com/zto.open.createOrder`
- **取消订单**: `https://japi.zto.com/zto.open.cancelOrder`
- **查询订单**: `https://japi.zto.com/zto.open.queryOrder`
- **查询轨迹**: `https://japi.zto.com/zto.open.queryTrack`

## 使用方法

### 1. 基本初始化

```php
// 测试环境
$ztoService = new ZtoService(
    'your_app_key',      // 应用Key
    'your_app_secret',   // 应用密钥
    true                 // true = 测试环境
);

// 正式环境
$ztoService = new ZtoService(
    'your_app_key',      // 应用Key
    'your_app_secret',   // 应用密钥
    false                // false = 正式环境
);
```

### 2. 环境切换

构造函数的第三个参数 `$isTest` 控制环境：
- `true`: 使用测试环境 (`https://japi-test.zto.com`)
- `false`: 使用正式环境 (`https://japi.zto.com`)

### 3. API调用示例

```php
// 创建订单
$orderData = $ztoService->buildOrderData($senderInfo, $receiverInfo, $orderInfo);
$result = $ztoService->createOrder($orderData);

// 查询订单
$result = $ztoService->queryOrder($orderId);

// 取消订单
$result = $ztoService->cancelOrder($orderId, '取消原因');

// 查询物流轨迹
$result = $ztoService->queryTrack($trackingNumber);
```

## 注意事项

1. **测试环境**：用于开发和测试，不会产生真实的快递订单
2. **正式环境**：用于生产环境，会产生真实的快递订单和费用
3. **API密钥**：请妥善保管您的AppKey和AppSecret，不要泄露给他人
4. **错误处理**：所有API调用都包含异常处理，请检查返回结果中的success字段

## 错误码说明

根据中通快递API文档，常见错误码：
- `S208`: COMPANY_ID不能为空
- 其他错误码请参考中通快递官方API文档

## 开发建议

1. 开发阶段使用测试环境进行调试
2. 充分测试后再切换到正式环境
3. 在正式环境中谨慎操作，避免产生不必要的费用
4. 建议通过配置文件管理环境切换，而不是硬编码