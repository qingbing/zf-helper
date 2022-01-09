# 助手类 SymbolHelper: 标点符号转换
- static halfAngle2FullWidth($string): 半角转换成全角
- static fullWidth2HalfAngle($string): 全角转换成半角

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
