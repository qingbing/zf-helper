# 片段 : "性别"标签

```php
class Model
{
    use TLabelSex;
}

/*
array(3) {
  [0]=>
  string(6) "秘密"
  [1]=>
  string(6) "男士"
  [2]=>
  string(6) "女士"
}
 */
var_dump(Model::sexLabels());
```
