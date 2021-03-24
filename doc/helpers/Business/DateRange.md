# 助手类 DateRange ： 时间段获取

## test 代码

```php
// 片段类型为 天
$range = DateRange::getInstance()
    ->setRangeType(DateRange::RANGE_TYPE_DAY)
    ->setDataType(DateRange::DATA_TYPE_DATETIME)
    ->setDateDelimiter('/')
    ->setStart("2021-02-24 02:03")
    ->setEnd("2021/02/25")
    ->getRange();
var_dump($range);
// 片段类型为 周
$range = DateRange::getInstance()
    ->setRangeType(DateRange::RANGE_TYPE_WEEK)
    ->setDataType(DateRange::DATA_TYPE_DATETIME)
    ->setDateDelimiter('/')
    ->setStart("2021-02-24 02:03")
    ->setEnd("2021/03/01")
    ->getRange();
var_dump($range);
// 片段类型为 月
$range = DateRange::getInstance()
    ->setRangeType(DateRange::RANGE_TYPE_MONTH)
    ->setDataType(DateRange::DATA_TYPE_DATE)
    ->setDateDelimiter('/')
    ->setStart("2021-02-24 02:03")
    ->setEnd("2021/03/01")
    ->getRange();
var_dump($range);
// 片段类型为 季
$range = DateRange::getInstance()
    ->setRangeType(DateRange::RANGE_TYPE_QUARTER)
    ->setDataType(DateRange::DATA_TYPE_DATE)
    ->setDateDelimiter('/')
    ->setStart("2021-02-24 02:03")
    ->setEnd("2021/04/01")
    ->getRange();
var_dump($range);
// 片段类型为 年
$range = DateRange::getInstance()
    ->setRangeType(DateRange::RANGE_TYPE_YEAR)
    ->setDataType(DateRange::DATA_TYPE_DATE)
    ->setDateDelimiter('/')
    ->setStart("2021-02-24 02:03")
    ->setEnd("2022/04/01")
    ->getRange();
var_dump($range);
```

## test 结果

```php
array(2) {
  [0]=>
  array(4) {
    ["start"]=>
    string(19) "2021/02/24 00:00:00"
    ["end"]=>
    string(19) "2021/02/24 23:59:59"
    ["label"]=>
    string(10) "2021/02/24"
    ["range"]=>
    string(10) "2021/02/24"
  }
  [1]=>
  array(4) {
    ["start"]=>
    string(19) "2021/02/25 00:00:00"
    ["end"]=>
    string(19) "2021/02/25 23:59:59"
    ["label"]=>
    string(10) "2021/02/25"
    ["range"]=>
    string(10) "2021/02/25"
  }
}
array(2) {
  [0]=>
  array(4) {
    ["start"]=>
    string(19) "2021/02/22 00:00:00"
    ["end"]=>
    string(19) "2021/02/28 23:59:59"
    ["label"]=>
    string(8) "2021-W08"
    ["range"]=>
    string(23) "2021/02/22 ~ 2021/02/28"
  }
  [1]=>
  array(4) {
    ["start"]=>
    string(19) "2021/03/01 00:00:00"
    ["end"]=>
    string(19) "2021/03/07 23:59:59"
    ["label"]=>
    string(8) "2021-W09"
    ["range"]=>
    string(23) "2021/03/01 ~ 2021/03/07"
  }
}
array(2) {
  [0]=>
  array(4) {
    ["start"]=>
    string(10) "2021/02/01"
    ["end"]=>
    string(10) "2021/02/28"
    ["label"]=>
    string(7) "2021-02"
    ["range"]=>
    string(23) "2021/02/01 ~ 2021/02/28"
  }
  [1]=>
  array(4) {
    ["start"]=>
    string(10) "2021/03/01"
    ["end"]=>
    string(10) "2021/03/31"
    ["label"]=>
    string(7) "2021-03"
    ["range"]=>
    string(23) "2021/03/01 ~ 2021/03/31"
  }
}
array(2) {
  [0]=>
  array(4) {
    ["start"]=>
    string(10) "2021/01/01"
    ["end"]=>
    string(10) "2021/03/31"
    ["label"]=>
    string(7) "2021-Q1"
    ["range"]=>
    string(23) "2021/01/01 ~ 2021/03/31"
  }
  [1]=>
  array(4) {
    ["start"]=>
    string(10) "2021/04/01"
    ["end"]=>
    string(10) "2021/06/30"
    ["label"]=>
    string(7) "2021-Q2"
    ["range"]=>
    string(23) "2021/04/01 ~ 2021/06/30"
  }
}
array(2) {
  [0]=>
  array(4) {
    ["start"]=>
    string(10) "2021/01/01"
    ["end"]=>
    string(10) "2021/12/31"
    ["label"]=>
    string(4) "2021"
    ["range"]=>
    string(23) "2021/01/01 ~ 2021/12/31"
  }
  [1]=>
  array(4) {
    ["start"]=>
    string(10) "2022/01/01"
    ["end"]=>
    string(10) "2022/12/31"
    ["label"]=>
    string(4) "2022"
    ["range"]=>
    string(23) "2022/01/01 ~ 2022/12/31"
  }
}
```
