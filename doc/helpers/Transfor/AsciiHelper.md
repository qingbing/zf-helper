# 助手类 AsciiHelper ： Ascii码转换
- static str2Binary(string $var) : 将字符串转换成二进制
- static str2Hex(string $var) : 将字符串转换成十六进制
- static binary2Str(string $var) : 二进制转换成字符串
- static hex2Str(string $var) : 十六进制转换成字符串


## test代码
```php
$str = "工作";
var_dump("string : " . $str);
$ascii = AsciiHelper::str2Binary($str);
var_dump("str2Binary ： " . $ascii);

$str = AsciiHelper::binary2Str($ascii);
var_dump("binary2Str ： " . $str);

$hex = AsciiHelper::str2Hex($str);
var_dump("str2Hex ： " . $hex);

$ascii = AsciiHelper::hex2Str($hex);
var_dump("hex2Str ： " . $ascii);

var_dump("-----------------------------------------");

$str = "phpcroner";
var_dump("string : " . $str);
$ascii = AsciiHelper::str2Binary($str);
var_dump("str2Binary ： " . $ascii);

$str = AsciiHelper::binary2Str($ascii);
var_dump("binary2Str ： " . $str);

$hex = AsciiHelper::str2Hex($str);
var_dump("str2Hex ： " . $hex);

$ascii = AsciiHelper::hex2Str($hex);
var_dump("hex2Str ： " . $ascii);
```

## test输出
```
string(15) "string : 工作"
string(63) "str2Binary ： 111001011011011110100101111001001011110110011100"
string(21) "binary2Str ： 工作"
string(24) "str2Hex ： E5B7A5E4BD9C"
string(18) "hex2Str ： 工作"
string(41) "-----------------------------------------"
string(18) "string : phpcroner"
string(87) "str2Binary ： 011100000110100001110000011000110111001001101111011011100110010101110010"
string(24) "binary2Str ： phpcroner"
string(30) "str2Hex ： 70687063726F6E6572"
string(21) "hex2Str ： phpcroner"
```