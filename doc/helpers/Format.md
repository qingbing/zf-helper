# 助手类 Format ： 常用格式化
- 获取当前纳米级时间表示 ： microDatetime()
- 返回数组的值 ： dataValue(string $key, $data = [])
- 标准格式化日期 ： date($time = null, $todayIfNull = true, $format = 'Y-m-d')
- 标准格式化日期 ： datetime($time = null, $nowIfNull = true, $format = 'Y-m-d H:i:s')
- 将浮点数保留 $precision 位小数 ： round(float $val, $precision = 2)
- 将浮点数转换成百分数表示 ： percent(float $val, $precision = 2)
- 用户名 隐秘显示 ： maskUsername(string $username)
- 姓名 隐秘显示 ： maskName(string $username)
- 隐秘身份证中的年月日 ： maskIdentity(string $identity)
- 手机号 隐秘显示 ： maskPhone(string $phone, $type = 0)
- 银行卡 隐秘显示 ： maskBankCard(string $cardNum, int $type = 0)
    
## test 代码

```php
// 数组取值
var_dump(Format::dataValue('name', ['name' => 'qingbing', 'sex' => 'nan']));
// 日期格式化
var_dump(Format::date());
var_dump(Format::date(time() - 86400 * 2));
// 时间格式化
var_dump(Format::datetime(time() - 86400 * 2));
var_dump(Format::microDateTime());

var_dump('=========');
var_dump(Format::round(12));
var_dump(Format::round(.0911));
var_dump(Format::round(12.0000, 6));
var_dump(Format::round(12.9999, 3));
var_dump(Format::round('12.9299'));
var_dump(Format::round(12.9219));

var_dump('=========');
var_dump(Format::percent(12));
var_dump(Format::percent(.0911));
var_dump(Format::percent(12.0000, 6));
var_dump(Format::percent(12.9999, 3));
var_dump(Format::percent('12.9299'));
var_dump(Format::percent(12.9219));

var_dump('=========');
var_dump(Format::maskUsername("qingbing1"));
var_dump(Format::maskUsername("杜小冰"));
var_dump(Format::maskName("杜小冰"));
var_dump(Format::maskIdentity("511623198803141189"));
var_dump(Format::maskPhone("13608051299"));
var_dump(Format::maskPhone("13608051299", 1));
var_dump(Format::maskPhone("13608051299", 2));
var_dump(Format::maskBankCard("123456789012345678"));
var_dump(Format::maskBankCard("123456789012345678", 1));
```

## test 结果

```php

string(8) "qingbing"
string(10) "2021-03-24"
string(10) "2021-03-22"
string(19) "2021-03-22 13:38:41"
string(26) "2021-03-24 13:38:41.785062"
string(9) "========="
string(5) "12.00"
string(4) "0.09"
string(9) "12.000000"
string(6) "13.000"
string(5) "12.93"
string(5) "12.92"
string(9) "========="
string(8) "1200.00%"
string(5) "9.11%"
string(12) "1200.000000%"
string(9) "1299.990%"
string(8) "1292.99%"
string(8) "1292.19%"
string(9) "========="
string(9) "qingb****"
string(7) "杜小*"
string(5) "杜**"
string(18) "511623********1189"
string(11) "136****1299"
string(8) "****1299"
string(10) "尾号1299"
string(19) "1234 **** **** 5678"
string(18) "1234**********5678"

```
