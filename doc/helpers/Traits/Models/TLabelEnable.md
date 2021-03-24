# 片段 : "启用状态"标签

```php
class Model
{
    use TLabelEnable;
}

/*
array(2) {
  [0]=>
  string(6) "禁用"
  [1]=>
  string(6) "启用"
}
 */
var_dump(Model::enableLabels());
```
