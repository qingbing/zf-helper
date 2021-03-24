
# ListIterator ： List迭代器
封装数组的迭代，其实可以直接迭代数组

## test代码
```php
$data = ["nan", "nv"];
$list = new ListIterator($data);
foreach ($list as $item => $value) {
    var_dump($item, $value);
}
var_dump($list);
```

## test输出

```
int(0)
string(3) "nan"
int(1)
string(2) "nv"
object(Zf\Helper\Iterators\ListIterator)#77 (2) {
  ["_items":"Zf\Helper\Iterators\ListIterator":private]=>
  &array(2) {
    [0]=>
    string(3) "nan"
    [1]=>
    string(2) "nv"
  }
  ["_index":"Zf\Helper\Iterators\ListIterator":private]=>
  int(2)
}
```
