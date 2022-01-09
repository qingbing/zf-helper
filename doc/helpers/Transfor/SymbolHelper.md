# 助手类 SymbolHelper: 标点符号转换
- static halfAngle2FullWidth($string): 半角转换成全角
- static fullWidth2HalfAngle($string): 全角转换成半角

## 实现原理
- 全角字符unicode编码从65281~65374 （十六进制 0xFF01 ~ 0xFF5E）
- 半角字符unicode编码从33~126 （十六进制 0x21~ 0x7E）
- 空格比较特殊,全角为 12288（0x3000）,半角为 32 （0x20）
- 因此: 除空格外,全角/半角按unicode编码排序在顺序上是对应的

## test代码
```php
$string = '你是,,,.。史 蒂夫；123史蒂夫的说法。';
var_dump($string);
$string = SymbolHelper::halfAngle2FullWidth($string);
var_dump($string);
$string = SymbolHelper::fullWidth2HalfAngle($string);
var_dump($string);
```

## test输出
```
string(50) "你是,,,.。史 蒂夫；123史蒂夫的说法。"
string(66) "你是，，，．。史　蒂夫；１２３史蒂夫的说法。"
string(48) "你是,,,.。史 蒂夫;123史蒂夫的说法。"
```
