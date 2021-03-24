
# MapIterator ： Map迭代器
封装键值数组的迭代，其实可以直接迭代数组

## test代码
```php
$data = ["nan" => "男", "nv" => "女"];
$list = new MapIterator($data);
foreach ($list as $item => $value) {
    var_dump($item, $value);
}
var_dump($list);
```

## test输出

```
string(3) "nan"
string(3) "男"
string(2) "nv"
string(3) "女"
object(Zf\Helper\Iterators\MapIterator)#77 (3) {
  ["_data":"Zf\Helper\Iterators\MapIterator":private]=>
  &array(2) {
    ["nan"]=>
    string(3) "男"
    ["nv"]=>
    string(3) "女"
  }
  ["_keys":"Zf\Helper\Iterators\MapIterator":private]=>
  array(2) {
    [0]=>
    string(3) "nan"
    [1]=>
    string(2) "nv"
  }
  ["_key":"Zf\Helper\Iterators\MapIterator":private]=>
  bool(false)
}
```
