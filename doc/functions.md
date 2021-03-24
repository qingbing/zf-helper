# 常用函数封装

## 1. replace : 信息模版替换
```php
// My name is qingbing
var_dump(replace('My name is {name}', [
    'name' => 'qingbing',
]));

// My name is qingbing
var_dump(replace('My name is {{name}}', [
    '{name}' => 'qingbing',
]));
```

## 2. is_json : 判断一个变量可否json化
```php
var_dump(is_json(1)); // true
var_dump(is_json("1")); // true
var_dump(is_json(true)); // true
var_dump(is_json('{"xx":"name"}')); // true
var_dump(is_json("good")); // false
var_dump(is_json("{xx:name}")); // false
var_dump(is_json("{'xx':'name'}")); // false
```

## 3. is_datetime : 判断一个变量是否是有效的日期格式
该函数只是简单的判断格式，不能严格判断日期的数字是否符合日期规范

```php
var_dump(is_datetime("2020-02-03")); // true
var_dump(is_datetime("2020/02/03", '\/')); // true
var_dump(is_datetime("2020-02-03", '\/')); // false
var_dump(is_datetime("2020-02-03 23:59:59")); // true
var_dump(is_datetime("2020/02/03 23:59:59", '\/')); // true
var_dump(is_datetime("2020-02-03 23:59:59", '\/')); // false
```

## 4. trim_data : 对数据递归使用 trim 函数

```php
// string(16) "this is my word."
var_dump(trim_data("  this is my word. "));

$data = [
    "field1" => " field1 ",
    "field2" => " field 2 ",
    "field3" => [
        "field11" => " field11 ",
        "field22" => " field 22 ",
    ],
];
var_dump(trim_data($data));
/*
 * ===== output start ======
array(3) {
  ["field1"]=>
  string(6) "field1"
  ["field2"]=>
  string(7) "field 2"
  ["field3"]=>
  array(2) {
    ["field11"]=>
    string(7) "field11"
    ["field22"]=>
    string(8) "field 22"
  }
}
 * ===== output end ======
 */

```

## 5. explode_data : 对数据进行 explode 处理，需要去掉空数据和数据左右空字符
```php
/*
array(4) {
  [0]=>
  string(1) "1"
  [1]=>
  string(1) "2"
  [2]=>
  string(2) "35"
  [3]=>
  string(2) "49"
}
 */
var_dump(explode_data("1,2,35, 49"));
/*
array(3) {
  [0]=>
  string(1) "1"
  [1]=>
  string(1) "2"
  [2]=>
  string(5) "35 49"
}
 */
var_dump(explode_data("1 | 2 | 35 49", '|'));
```