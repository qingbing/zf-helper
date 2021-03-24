# 片段 : "禁用状态"标签

```php
class Model
{
    use TLabelForbidden;
}

/*
array(2) {
  [0]=>
  string(6) "启用"
  [1]=>
  string(6) "禁用"
}
 */
var_dump(Model::forbiddenLabels());
```
