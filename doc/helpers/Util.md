# 助手类Util ： 功能集合
- 生成随机字符,可作为随机密码使用 ： randomString(): string
- 获取一个唯一的id ： uniqid(): string
- 内存单位转换 ： switchMemoryCapacity($size, string $targetUnit = 'KB', string $sourceUnit = 'B'): ?string


## test 代码

```php
var_dump(Util::randomString());
var_dump(Util::randomString(64, 15));

$id = Util::uniqid();
var_dump($id);

var_dump(Util::switchMemoryCapacity('1025b'));
var_dump(Util::switchMemoryCapacity('1075mb', 'gb'));
var_dump(Util::switchMemoryCapacity('1025', 'mb', 'kb'));


$array = [
    "name" => "qingbing",
    "sex"  => "nan",
    "age"  => "18",
];
$filterArray = Util::filterArrayByKeys($array, ['name', 'sex', 'grade']);
var_dump($filterArray);
```

## test 结果

```php
string(32) "LPCFTSCG8UPWVJM4J9Y57XXWCDEW7R4L"
string(64) "NVtmMW5RBmM=ptZ4cX3Sn0IuaK$X7ObdWE$JzqJUka7KDksrZgVdVr93z$xU2U-K"
string(32) "605acec5c0a80109fff605acec51c730"
string(7) "1.00 KB"
string(7) "1.05 GB"
string(7) "1.00 MB"
array(2) {
  ["name"]=>
  string(8) "qingbing"
  ["sex"]=>
  string(3) "nan"
}
```
