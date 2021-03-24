# 助手类 Format ： 常用格式化
- 返回数组的值 ： dataValue(string $key, $data = [])
- 标准格式化日期 ： date($time = null, $todayIfNull = true, $format = 'Y-m-d')
- 标准格式化日期 ： datetime($time = null, $nowIfNull = true, $format = 'Y-m-d H:i:s')
- 获取当前纳米级时间表示 ： microDatetime()

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
```

## test 结果

```php
string(8) "qingbing"
string(10) "2021-03-24"
string(10) "2021-03-22"
string(19) "2021-03-22 02:34:14"
string(26) "2021-03-24 02:34:14.917199"
```
