# 助手类 DeepTree ： array-deep实现的 pid-id 树形结构构造
- 继承 \Zf\Helper\Abstracts\TreeData
- 提供方法参考[TreeData](../Abstracts/TreeData.md)


## 测试代码
```php
$data = [
    ['id' => 1, 'pid' => 0, 'data' => 'data1'],
    ['id' => 2, 'pid' => 1, 'data' => 'data2'],
    ['id' => 3, 'pid' => 2, 'data' => 'data3'],
    ['id' => 4, 'pid' => 1, 'data' => 'data4'],
    ['id' => 5, 'pid' => 0, 'data' => 'data5'],
];
$tree = DeepTree::getInstance()
    ->setFilter(function ($val) {
        return true;
    })
    ->setSourceData($data)
    ->setId("id")
    ->setPid("pid")
    ->setTopTag(0)
    ->getTreeData();
var_dump($tree);
```

## 测试结果
```text
array(2) {
  [0]=>
  array(3) {
    ["deep"]=>
    int(0)
    ["attr"]=>
    array(3) {
      ["id"]=>
      int(1)
      ["pid"]=>
      int(0)
      ["data"]=>
      string(5) "data1"
    }
    ["data"]=>
    array(2) {
      [0]=>
      array(3) {
        ["deep"]=>
        int(1)
        ["attr"]=>
        array(3) {
          ["id"]=>
          int(2)
          ["pid"]=>
          int(1)
          ["data"]=>
          string(5) "data2"
        }
        ["data"]=>
        array(1) {
          [0]=>
          array(3) {
            ["deep"]=>
            int(2)
            ["attr"]=>
            array(3) {
              ["id"]=>
              int(3)
              ["pid"]=>
              int(2)
              ["data"]=>
              string(5) "data3"
            }
            ["data"]=>
            array(0) {
            }
          }
        }
      }
      [1]=>
      array(3) {
        ["deep"]=>
        int(1)
        ["attr"]=>
        array(3) {
          ["id"]=>
          int(4)
          ["pid"]=>
          int(1)
          ["data"]=>
          string(5) "data4"
        }
        ["data"]=>
        array(0) {
        }
      }
    }
  }
  [1]=>
  array(3) {
    ["deep"]=>
    int(0)
    ["attr"]=>
    array(3) {
      ["id"]=>
      int(5)
      ["pid"]=>
      int(0)
      ["data"]=>
      string(5) "data5"
    }
    ["data"]=>
    array(0) {
    }
  }
}

```
