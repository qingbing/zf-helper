# 助手类 ZList ： 列表，提供push，pop，unshift，shift等操作

## test 代码

```php
// 实例化列表
$list = new ZList();
// 添加列表
$list->push(['id' => '1', 'name' => 'aa']);
$list->push(['id' => '2', 'name' => 'bb']);
$list->push(['id' => '3', 'name' => 'cc']);
$list->push(['id' => '4', 'name' => 'dd']);
$list->push(['id' => '5', 'name' => 'ee']);
$list->unshift(['id' => '6', 'name' => 'ee']);
// 遍历列表
foreach ($list as $k => $v) {
    var_dump($v);
}
// 统计列表包含元素个数
var_dump(count($list));
var_dump($list);
// 移除最后的元素
var_dump($list->shift());
var_dump($list);

// 移除最后的元素
var_dump($list->pop());
var_dump($list);
```

## test 结果

```php

array(2) {
  ["id"]=>
  string(1) "6"
  ["name"]=>
  string(2) "ee"
}
array(2) {
  ["id"]=>
  string(1) "1"
  ["name"]=>
  string(2) "aa"
}
array(2) {
  ["id"]=>
  string(1) "2"
  ["name"]=>
  string(2) "bb"
}
array(2) {
  ["id"]=>
  string(1) "3"
  ["name"]=>
  string(2) "cc"
}
array(2) {
  ["id"]=>
  string(1) "4"
  ["name"]=>
  string(2) "dd"
}
array(2) {
  ["id"]=>
  string(1) "5"
  ["name"]=>
  string(2) "ee"
}
int(6)
object(Zf\Helper\ZList)#77 (3) {
  ["_data":"Zf\Helper\ZList":private]=>
  array(6) {
    [0]=>
    array(2) {
      ["id"]=>
      string(1) "6"
      ["name"]=>
      string(2) "ee"
    }
    [1]=>
    array(2) {
      ["id"]=>
      string(1) "1"
      ["name"]=>
      string(2) "aa"
    }
    [2]=>
    array(2) {
      ["id"]=>
      string(1) "2"
      ["name"]=>
      string(2) "bb"
    }
    [3]=>
    array(2) {
      ["id"]=>
      string(1) "3"
      ["name"]=>
      string(2) "cc"
    }
    [4]=>
    array(2) {
      ["id"]=>
      string(1) "4"
      ["name"]=>
      string(2) "dd"
    }
    [5]=>
    array(2) {
      ["id"]=>
      string(1) "5"
      ["name"]=>
      string(2) "ee"
    }
  }
  ["_count":"Zf\Helper\ZList":private]=>
  int(6)
  ["_readOnly":"Zf\Helper\ZList":private]=>
  bool(false)
}
array(2) {
  ["id"]=>
  string(1) "6"
  ["name"]=>
  string(2) "ee"
}
object(Zf\Helper\ZList)#77 (3) {
  ["_data":"Zf\Helper\ZList":private]=>
  array(5) {
    [0]=>
    array(2) {
      ["id"]=>
      string(1) "1"
      ["name"]=>
      string(2) "aa"
    }
    [1]=>
    array(2) {
      ["id"]=>
      string(1) "2"
      ["name"]=>
      string(2) "bb"
    }
    [2]=>
    array(2) {
      ["id"]=>
      string(1) "3"
      ["name"]=>
      string(2) "cc"
    }
    [3]=>
    array(2) {
      ["id"]=>
      string(1) "4"
      ["name"]=>
      string(2) "dd"
    }
    [4]=>
    array(2) {
      ["id"]=>
      string(1) "5"
      ["name"]=>
      string(2) "ee"
    }
  }
  ["_count":"Zf\Helper\ZList":private]=>
  int(5)
  ["_readOnly":"Zf\Helper\ZList":private]=>
  bool(false)
}
array(2) {
  ["id"]=>
  string(1) "5"
  ["name"]=>
  string(2) "ee"
}
object(Zf\Helper\ZList)#77 (3) {
  ["_data":"Zf\Helper\ZList":private]=>
  array(4) {
    [0]=>
    array(2) {
      ["id"]=>
      string(1) "1"
      ["name"]=>
      string(2) "aa"
    }
    [1]=>
    array(2) {
      ["id"]=>
      string(1) "2"
      ["name"]=>
      string(2) "bb"
    }
    [2]=>
    array(2) {
      ["id"]=>
      string(1) "3"
      ["name"]=>
      string(2) "cc"
    }
    [3]=>
    array(2) {
      ["id"]=>
      string(1) "4"
      ["name"]=>
      string(2) "dd"
    }
  }
  ["_count":"Zf\Helper\ZList":private]=>
  int(4)
  ["_readOnly":"Zf\Helper\ZList":private]=>
  bool(false)
}

```

