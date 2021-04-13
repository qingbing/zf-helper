# 业务助手 IpHelper ： Ip 地址助手
- 提供 ip 地址的多样化配置范围检查 ： inRange($ip, $range): bool

## test 代码

```php
$isIp = IpHelper::inRange('1.2.3.3', '1.2.3.3');
var_dump($isIp);

$isIp = IpHelper::inRange('1.2.3.3', '1.2.3.*');
var_dump($isIp);

$isIp = IpHelper::inRange('1.2.3.23', '1.2.3.0~1.2.3.255');
var_dump($isIp);

$isIp = IpHelper::inRange('1.2.3.3', '1.2.3/255.255.255.0');
var_dump($isIp);

$isIp = IpHelper::inRange('1.2.3.3', '1.2.3/255.255.255.*');
var_dump($isIp);

$isIp = IpHelper::inRange('1.2.3.3', '1.2.3/24');
var_dump($isIp);
```

## test 结果
```text
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
```
