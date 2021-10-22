# 业务类 : 行政区划管理
- 解析代码成省市区及代码 : releaseCode(string $code): array
- 获取代码的子区域 : getChildren(string $code): array
- 返回所有城镇 : getAllTowns()


# test 代码

```php
// 解析行政区划代码
var_dump(Region::getInstance()->releaseCode(511600));
// 获取所有省份
var_dump(Region::getInstance()->getChildren(000000));
// 获取某个省下所有市区
var_dump(Region::getInstance()->getChildren(510000));
// 获取某个市区下所有城镇
var_dump(Region::getInstance()->getChildren(511600));
// 获取所有城镇代码
var_dump(Region::getInstance()->getAllTowns());
```

# test 结果

```php
array(6) {
  ["province_code"]=>
  string(6) "510000"
  ["city_code"]=>
  string(6) "511600"
  ["town_code"]=>
  string(0) ""
  ["province_name"]=>
  string(9) "四川省"
  ["city_name"]=>
  string(9) "广安市"
  ["town_name"]=>
  string(0) ""
}
array(31) {
  [110000]=>
  string(9) "北京市"
  [120000]=>
  string(9) "天津市"
  [130000]=>
  string(9) "河北省"
  [140000]=>
  string(9) "山西省"
  [150000]=>
  string(18) "内蒙古自治区"
  [210000]=>
  string(9) "辽宁省"
  [220000]=>
  string(9) "吉林省"
  [230000]=>
  string(12) "黑龙江省"
  [310000]=>
  string(9) "上海市"
  [320000]=>
  string(9) "江苏省"
  ...
}
array(21) {
  [510100]=>
  string(9) "成都市"
  [510300]=>
  string(9) "自贡市"
  [510400]=>
  string(12) "攀枝花市"
  [510500]=>
  string(9) "泸州市"
  [510600]=>
  string(9) "德阳市"
  [510700]=>
  string(9) "绵阳市"
  [510800]=>
  string(9) "广元市"
  ...
}
array(7) {
  [511601]=>
  string(9) "市辖区"
  [511602]=>
  string(9) "广安区"
  [511603]=>
  string(9) "前锋区"
  [511621]=>
  string(9) "岳池县"
  [511622]=>
  string(9) "武胜县"
  [511623]=>
  string(9) "邻水县"
  [511681]=>
  string(9) "华蓥市"
}
array(3073) {
  [110101]=>
  string(9) "东城区"
  [110102]=>
  string(9) "西城区"
  [110105]=>
  string(9) "朝阳区"
  ...
}

```
