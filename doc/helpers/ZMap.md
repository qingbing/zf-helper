# 助手类 ZMap ： Map，提供add,get,remove,clear,count等操作

## test 代码

```php
// 数组创建 map
$map1 = new ZMap([
    'name' => 'xx',
    'sex'  => 'male',
]);
$map2 = new ZMap([
    'name' => 'php',
    'age'  => '10',
]);
// map 创建 map
$map = new ZMap($map1);
// 合并 map
$map->mergeWith($map2);
// 添加
$map->add('height', 80);
$map->add('function', function () {
    var_dump('function-method');
});
// 直接调用
call_user_func($map->get('function'));
$map->get('function')();
// 删除
$map->remove('function');
var_dump($map->count);
// 迭代遍历
foreach ($map as $key => $value) {
    if (is_callable($value)) {
        var_dump("==={$key}===");
        call_user_func($value);
    } else {
        var_dump("==={$key} : {$value}===");
    }
}
var_dump($map);
```

## test 结果

```php
string(15) "function-method"
string(15) "function-method"
int(4)
string(16) "===name : php==="
string(16) "===sex : male==="
string(14) "===age : 10==="
string(17) "===height : 80==="
object(Zf\Helper\ZMap)#81 (2) {
  ["_data":"Zf\Helper\ZMap":private]=>
  array(4) {
    ["name"]=>
    string(3) "php"
    ["sex"]=>
    string(4) "male"
    ["age"]=>
    string(2) "10"
    ["height"]=>
    int(80)
  }
  ["_readOnly":"Zf\Helper\ZMap":private]=>
  bool(false)
}
```
