# 片段 : "是/否"标签

```php
class Model
{
    use TLabelYesNo;
}

/*
array(2) {
  [0]=>
  string(3) "否"
  [1]=>
  string(3) "是"
}
 */
var_dump(Model::isLabels());
/*
array(2) {
  [0]=>
  string(3) "否"
  [1]=>
  string(3) "是"
}
 */
var_dump(Model::yesNoLabels());
```
