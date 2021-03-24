# 片段 : "删除状态"标签

```php
class Model
{
    use TLabelDeleted;
}

/*
array(2) {
  [0]=>
  string(6) "正常"
  [1]=>
  string(9) "已删除"
}
 */
var_dump(Model::deletedLabels());
```
