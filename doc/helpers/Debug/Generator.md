# 辅助类 : 辅助生成器
- 根据提供的 区划代码、生日、性别 生成随机身份证号 : static IdCard($areaCode, $birthday, $sex = IdentityParser::GENDER_FEMALE): string
- 在时间区间范围内随机生成身份证号 : static randIdCard($minDate = '1949-10-01', $maxDate = '2021-01-01')


# test 代码

```php
// 指定区域、生日、性别生成身份证
$id = Generator::IdCard(511623, 19880101, 0);
var_dump($id);
$id = Generator::IdCard(511623, 19880101, 0);
var_dump($id);
// 随机生成身份证
var_dump(Generator::randIdCard());
var_dump(Generator::randIdCard());
var_dump(Generator::randIdCard());
var_dump(Generator::randIdCard());
```

# test 结果

```php
string(18) "511623198801014731"
string(18) "511623198801011792"
string(18) "431281199005190394"
string(18) "360426195408263518"
string(18) "230828201607268489"
string(18) "540202195405311731"
```
