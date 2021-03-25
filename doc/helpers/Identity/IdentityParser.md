# 助手类 IdentityParser ： 身份证号解析
- 身份证异常信息 : invalidTypes()
- 性别集合 ： genders()
- 实例设置身份证号码 ： setIdCard(string $idCardNo)
- 校验是身份证号是否有效 ： isValid(): bool
- 无效代码 ： getInvalidType(): int
- 返回无效消息 ： getInvalidMessage(): string
- 验证是否合法身份证，不合法跑出异常 ： invalidThrow()
- 获取18位身份证号码 ： getFullIdCardNo(): string
- 获取出生日期 ： getBirthday($format = 'Y-m-d'): string
- 获取周岁年龄 ： getAge($now = null): int
- 获取性别 ： getGender(): int
- 获取区域信息 ： getRegion()

## test 代码

```php
$idCardNo = '130503196704010023';
$parser   = IdentityParser::getInstance()
    ->setIdCard($idCardNo);
var_dump($idCardNo);
// 校验生份证号是否有效
if (!$parser->isValid()) {
    var_dump($parser->invalidType);
    var_dump($parser->invalidMessage);
}
$idCardNo = '130503670401001';
var_dump($idCardNo);
var_dump($parser->getFullIdCardNo());
$parser = IdentityParser::getInstance()
    ->setIdCard($idCardNo);
// 校验生份证号是否有效
var_dump($parser->isValid());
if ($parser->isValid()) {
    var_dump($parser->birthday);
    var_dump($parser->age);
    var_dump($parser->getAge("2021-04-01"));
    var_dump($parser->gender);
    var_dump($parser->region);
}
```

## test 结果

```php
string(18) "130503196704010023"
int(4)
string(24) "身份证校验码无效"
string(15) "130503670401001"
string(18) "130503196704010023"
bool(true)
string(10) "1967-04-01"
int(53)
int(54)
int(1)
array(3) {
  ["province"]=>
  string(9) "河北省"
  ["city"]=>
  string(9) "邢台市"
  ["district"]=>
  string(9) "桥西区"
}
```
