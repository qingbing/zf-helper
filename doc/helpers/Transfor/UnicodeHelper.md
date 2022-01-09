# 辅助类 UnicodeHelper : Unicode编码转换
- static string2Unicode8($string, $type = NumberHelper::TYPE_HEX) : 将字符串转换成utf-8的进制编码
- static unicode82String($code, $type = NumberHelper::TYPE_HEX) : 将utf-8的进制编码转换成字符串
- static char2Unicode($char, $length = 0) : unicode码转换成utf-8字符
- static unicode2Char($unicode) : 将字符串转换成utf-8的进制编码
- static string2Unicode($string, $type = NumberHelper::TYPE_HEX, $unicodeByte = 4) : 将字符串转换成unicode的进制编码
- static unicode2String($code, $type = NumberHelper::TYPE_HEX, $unicodeByte = 4) : 将unicode的进制编码转换成字符串

## unicode 编码介绍

Utf-8字符编码转换成Unicode参考下面列表，将"x"从后向前排列，位数补足8的倍数(前位补0)

| Unicode 编码范围 | Utf-8 表示 | Unicode 字节表示 |
|:---|:---|:---|
| U-00000000 - U-0000007F | 0xxxxxxx | 1*0 + 1u |
| U-00000080 - U-000007FF | 110xxxxx 10xxxxxx | 5*0 + 2u |
| U-00000800 - U-0000FFFF | 1110xxxx 10xxxxxx 10xxxxxx | 0*0 + 2u |
| U-00010000 - U-001FFFFF | 11110xxx 10xxxxxx 10xxxxxx 10xxxxxx | 3*0 + 3u |
| U-00200000 - U-03FFFFFF | 111110xx 10xxxxxx 10xxxxxx 10xxxxxx 10xxxxxx | 6*0 + 4u |
| U-04000000 - U-7FFFFFFF | 1111110x 10xxxxxx 10xxxxxx 10xxxxxx 10xxxxxx 10xxxxxx | 1*0 + 4u |

## test 代码

```php
$string = 'phpcorner Php小刀';
var_dump("====== utf-8编码转换 ======");
// 十六进制
var_dump("十六进制");
$code = UnicodeHelper::string2Unicode8($string);
var_dump($code);
$newString = UnicodeHelper::unicode82String($code);
var_dump($newString);

// 二进制
var_dump("二进制");
$code = UnicodeHelper::string2Unicode8($string, NumberHelper::TYPE_BINARY);
var_dump($code);
$newString = UnicodeHelper::unicode82String($code, NumberHelper::TYPE_BINARY);
var_dump($newString);

// 八进制
var_dump("八进制");
$code = UnicodeHelper::string2Unicode8($string, NumberHelper::TYPE_OCTAL);
var_dump($code);
$newString = UnicodeHelper::unicode82String($code, NumberHelper::TYPE_OCTAL);
var_dump($newString);

// 64进制
var_dump("64进制");
$code = UnicodeHelper::string2Unicode8($string, NumberHelper::TYPE_BASE64);
var_dump($code);
$newString = UnicodeHelper::unicode82String($code, NumberHelper::TYPE_BASE64);
var_dump($newString);

$char = '在';
var_dump("====== 字符编码转换 ======");
var_dump("字符转化");
$code = UnicodeHelper::char2Unicode($char, 4);
var_dump($code);
$newChar = UnicodeHelper::unicode2Char($code);
var_dump($newChar);

$string = 'phpcorner Php小刀';
var_dump("====== unicode编码转换 ======");
// 十六进制
var_dump('十六进制');
$code = UnicodeHelper::string2Unicode($string);
var_dump($code);
$newString = UnicodeHelper::unicode2String($code);
var_dump($newString);

// 二进制
var_dump('二进制');
$code = UnicodeHelper::string2Unicode($string, NumberHelper::TYPE_BINARY);

var_dump(NumberHelper::binaryToHex($code));
var_dump($code);
$newString = UnicodeHelper::unicode2String($code, NumberHelper::TYPE_BINARY);
var_dump($newString);

// 八进制
var_dump('八进制');
$code = UnicodeHelper::string2Unicode($string, NumberHelper::TYPE_OCTAL);
var_dump($code);
var_dump(NumberHelper::octalToHex($code));
$newString = UnicodeHelper::unicode2String($code, NumberHelper::TYPE_OCTAL);
var_dump($newString);

// 64进制
var_dump('64进制');
$code = UnicodeHelper::string2Unicode($string, NumberHelper::TYPE_BASE64);
var_dump($code);
var_dump(NumberHelper::base64ToHex($code));
$newString = UnicodeHelper::unicode2String($code, NumberHelper::TYPE_BASE64);
var_dump($newString);
```

## test 结果

```text
string(31) "====== utf-8编码转换 ======"
string(12) "十六进制"
string(38) "706870636f726e657220506870e5b08fe58880"
string(19) "phpcorner Php小刀"
string(9) "二进制"
string(152)
"01110000011010000111000001100011011011110111001001101110011001010111001000100000010100000110100001110000111001011011000010001111111001011000100010000000"
string(19) "phpcorner Php小刀"
string(9) "八进制"
string(51) "160320701433367115631271040240641607133021771304200"
string(19) "phpcorner Php小刀"
string(8) "64进制"
string(26) "1Mq71zrT9Kpn8wk6xMVr2fVoy0"
string(19) "phpcorner Php小刀"
string(32) "====== 字符编码转换 ======"
string(12) "字符转化"
string(4) "5728"
string(3) "在"
string(33) "====== unicode编码转换 ======"
string(12) "十六进制"
string(58) "70006800700063006f0072006e0065007200200050006800705c0f5200"
string(19) "phpcorner Php小刀"
string(9) "二进制"
string(58) "70006800700063006f0072006e0065007200200050006800705c0f5200"
string(232)
"0111000000000000011010000000000001110000000000000110001100000000011011110000000001110010000000000110111000000000011001010000000001110010000000000010000000000000010100000000000001101000000000000111000001011100000011110101001000000000"
string(19) "phpcorner Php小刀"
string(9) "八进制"
string(78) "070000320001600006140033600162000670003120016200020000240001500007013403651000"
string(58) "70006800700063006f0072006e0065007200200050006800705c0f5200"
string(19) "phpcorner Php小刀"
string(8) "64进制"
string(39) "700q01M06c0rM1O06U0pg1O0200k01E071s3R80"
string(58) "70006800700063006f0072006e0065007200200050006800705c0f5200"
string(19) "phpcorner Php小刀"
```
