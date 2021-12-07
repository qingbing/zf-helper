# 助手类 ObjectTree ： Object实现的 pid-id 树形结构构造
- 继承 \Zf\Helper\Abstracts\TreeData
- 提供方法参考[TreeData](../Abstracts/TreeData.md)
- 额外提供链式设置方法
    - setNeedEncodeData(bool $needEncodeData = false) : 设置数据源是否需要重新object化
    - setSubDataName(string $subDataName) : 设置子项目键名

## 测试代码
```php
$data = [
    ['id' => 1, 'pid' => 0, 'data' => 'data1'],
    ['id' => 2, 'pid' => 1, 'data' => 'data2'],
    ['id' => 3, 'pid' => 2, 'data' => 'data3'],
    ['id' => 4, 'pid' => 1, 'data' => 'data4'],
    ['id' => 5, 'pid' => 0, 'data' => 'data5'],
];
$tree = ObjectTree::getInstance()
    ->setFilter(function ($val) {
        return true;
    })
    ->setSourceData($data)
    ->setId("id")
    ->setPid("pid")
    ->setTopTag(0)
    ->setSubDataName('subItems')
    ->getTreeData();
var_dump($tree);
```

## 测试结果
```text
array(2) {
  [1]=>
  object(stdClass)#166 (4) {
    ["id"]=>
    int(1)
    ["pid"]=>
    int(0)
    ["data"]=>
    string(5) "data1"
    ["subItems"]=>
    array(2) {
      [0]=>
      object(stdClass)#167 (4) {
        ["id"]=>
        int(2)
        ["pid"]=>
        int(1)
        ["data"]=>
        string(5) "data2"
        ["subItems"]=>
        array(1) {
          [0]=>
          object(stdClass)#168 (3) {
            ["id"]=>
            int(3)
            ["pid"]=>
            int(2)
            ["data"]=>
            string(5) "data3"
          }
        }
      }
      [1]=>
      object(stdClass)#169 (3) {
        ["id"]=>
        int(4)
        ["pid"]=>
        int(1)
        ["data"]=>
        string(5) "data4"
      }
    }
  }
  [5]=>
  object(stdClass)#170 (3) {
    ["id"]=>
    int(5)
    ["pid"]=>
    int(0)
    ["data"]=>
    string(5) "data5"
  }
}
```
