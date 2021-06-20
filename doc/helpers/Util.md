# 助手类Util ： 功能集合
- 获取一个唯一的id ： uniqid(): string
- 内存单位转换 ： switchMemoryCapacity($size, string $targetUnit = 'KB', string $sourceUnit = 'B'): ?string


## test 代码

```php
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
