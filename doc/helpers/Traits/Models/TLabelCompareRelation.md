# 片段 : "对比关系"标签
- compareLabels() : 对比关系map
- getCompareEntity() : 获取对比关系代码实体

# test 代码
```php
var_dump(TLabelCompareRelation::compareLabels());
var_dump(TLabelCompareRelation::getCompareEntity(COMPARE_EQ));
var_dump(TLabelCompareRelation::getCompareEntity(COMPARE_NE));
var_dump(TLabelCompareRelation::getCompareEntity(COMPARE_GT));
var_dump(TLabelCompareRelation::getCompareEntity(COMPARE_GE));
var_dump(TLabelCompareRelation::getCompareEntity(COMPARE_LT));
var_dump(TLabelCompareRelation::getCompareEntity(COMPARE_LE));
```

# test 输出
```text
array(6) {
  ["eq"]=>
  string(6) "等于"
  ["ne"]=>
  string(9) "不等于"
  ["gt"]=>
  string(6) "大于"
  ["ge"]=>
  string(12) "大于等于"
  ["lt"]=>
  string(6) "小于"
  ["le"]=>
  string(12) "小于等于"
}
string(1) "="
string(2) "!="
string(1) ">"
string(2) ">="
string(1) "<"
string(2) "<="
```

