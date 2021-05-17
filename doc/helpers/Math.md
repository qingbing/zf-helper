# 助手类 Math ： 数学函数
- 浮点数小数点格式化 ： round($val, int $precision = 2)
- 除法 ： division($total, $piece, ?int $precision = null)

## test 代码

```php
var_dump(Math::round(0));
var_dump(Math::round(1.222));
var_dump(Math::round(1.11111, 3));
var_dump(Math::round('0'));
var_dump(Math::round('1.222'));
var_dump(Math::round('1.11111', 3));

var_dump(Math::division(0, 1));
var_dump(Math::division(1, 0));
var_dump(Math::division(0, 0));
var_dump(Math::division(0, 0, 2));
var_dump(Math::division(2, 3, 3));
```

## test 结果

```php
string(4) "0.00"
string(4) "1.22"
string(5) "1.111"
string(4) "0.00"
string(4) "1.22"
string(5) "1.111"
int(0)
int(0)
int(0)
string(4) "0.00"
string(4) "0.67"
```