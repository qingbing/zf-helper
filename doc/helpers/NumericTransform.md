# 辅助类 : 进制转化
- static decToBase(int $n, int $base, $length = 0) : 任意进制数转化，不能大于 65
- static binaryToOctal($n) : 二进制转换成八进制数
- static binaryToDec($n) : 二进制转换成十进制数
- static binaryToHex($n) : 二进制转换成十六进制数
- static octalToBinary($n) : 八进制转换成二进制数
- static octalToDec($n) : 八进制转换成十进制数
- static octalToHex($n) : 八进制转换成十六进制数
- static decToBinary($n) : 十进制转换成二进制数
- static decToOctal($n) : 十进制转换成八进制数
- static decToHex($n) : 十进制转换成十六进制数
- static hexToBinary($n) : 十六进制转换成二进制数
- static hexToOctal($n) : 十六进制转换成八进制数
- static hexToDec($n) : 十六进制转换成十进制数

## test 代码

```php
// 十六进制转换成十进制数
var_dump('===== 十六进制转换成十进制数 =====');
var_dump(NumericTransform::hexToDec('1C'));
var_dump(NumericTransform::hexToDec('431'));
var_dump(NumericTransform::hexToDec('1984'));
// 十六进制转换成八进制数
var_dump('===== 十六进制转换成八进制数 =====');
var_dump(NumericTransform::hexToOctal('1C'));
var_dump(NumericTransform::hexToOctal('431'));
var_dump(NumericTransform::hexToOctal('1984'));
// 十六进制转换成十六进制数
var_dump('===== 十六进制转换成十六进制数 =====');
var_dump(NumericTransform::hexToBinary('1C'));
var_dump(NumericTransform::hexToBinary('431'));
var_dump(NumericTransform::hexToBinary('1984'));
// 十进制转换成十六进制数
var_dump('===== 十进制转换成十六进制数 =====');
var_dump(NumericTransform::decToHex(28));
var_dump(NumericTransform::decToHex(1073));
var_dump(NumericTransform::decToHex(6532));
// 十进制转换成八进制数
var_dump('===== 十进制转换成八进制数 =====');
var_dump(NumericTransform::decToOctal(23));
var_dump(NumericTransform::decToOctal(1073));
var_dump(NumericTransform::decToOctal(6532));
// 十进制转换成二进制数
var_dump('===== 十进制转换成二进制数 =====');
var_dump(NumericTransform::decToBinary(23));
var_dump(NumericTransform::decToBinary(1073));
var_dump(NumericTransform::decToBinary(6532));
// 十进制转换成二进制数
var_dump('===== 十进制转换成二进制数 =====');
var_dump(NumericTransform::decToBinary(23));
var_dump(NumericTransform::decToBinary(1073));
var_dump(NumericTransform::decToBinary(6532));
// 八进制转换成十进制数
var_dump('===== 八进制转换成十进制数 =====');
var_dump(NumericTransform::octalToHex(23));
var_dump(NumericTransform::octalToHex(1073));
var_dump(NumericTransform::octalToHex(6532));
// 八进制转换成十进制数
var_dump('===== 八进制转换成十进制数 =====');
var_dump(NumericTransform::octalToDec(23));
var_dump(NumericTransform::octalToDec(1073));
var_dump(NumericTransform::octalToDec(6532));
// 八进制转换成二进制数
var_dump('===== 八进制转换成二进制数 =====');
var_dump(NumericTransform::octalToBinary(23));
var_dump(NumericTransform::octalToBinary(1073));
var_dump(NumericTransform::octalToBinary(6532));
// 二进制转换成十六进制数
var_dump('===== 二进制转换成十六进制数 =====');
var_dump(NumericTransform::binaryToHex(101000));
var_dump(NumericTransform::binaryToHex(101011));
var_dump(NumericTransform::binaryToHex(101101));
// 二进制转换成八进制数
var_dump('===== 二进制转换成八进制数 =====');
var_dump(NumericTransform::binaryToOctal(101000));
var_dump(NumericTransform::binaryToOctal(101011));
var_dump(NumericTransform::binaryToOctal(101101));
// 二进制转换成十进制数
var_dump('===== 二进制转换成十进制数 =====');
var_dump(NumericTransform::binaryToDec(101000));
var_dump(NumericTransform::binaryToDec(101011));
var_dump(NumericTransform::binaryToDec(101101));
// 任意进制数转换
var_dump('===== 任意进制数转换 =====');
var_dump(NumericTransform::decToBase(64, 62, 6));
var_dump(NumericTransform::decToBase(3844, 62, 6));
var_dump(NumericTransform::decToBase(13457893844, 62, 6));
var_dump(NumericTransform::decToBase(13444443844, 62, 6));
```

## test 结果

```text
string(45) "===== 十六进制转换成十进制数 ====="
int(28)
int(1073)
int(6532)
string(45) "===== 十六进制转换成八进制数 ====="
string(2) "34"
string(4) "2061"
string(5) "14604"
string(48) "===== 十六进制转换成十六进制数 ====="
string(5) "11100"
string(11) "10000110001"
string(13) "1100110000100"
string(45) "===== 十进制转换成十六进制数 ====="
string(2) "1C"
string(3) "431"
string(4) "1984"
string(42) "===== 十进制转换成八进制数 ====="
string(2) "27"
string(4) "2061"
string(5) "14604"
string(42) "===== 十进制转换成二进制数 ====="
string(5) "10111"
string(11) "10000110001"
string(13) "1100110000100"
string(42) "===== 十进制转换成二进制数 ====="
string(5) "10111"
string(11) "10000110001"
string(13) "1100110000100"
string(42) "===== 八进制转换成十进制数 ====="
string(2) "13"
string(3) "23B"
string(3) "D5A"
string(42) "===== 八进制转换成十进制数 ====="
int(19)
int(571)
int(3418)
string(42) "===== 八进制转换成二进制数 ====="
string(5) "10011"
string(10) "1000111011"
string(12) "110101011010"
string(45) "===== 二进制转换成十六进制数 ====="
string(2) "28"
string(2) "2B"
string(2) "2D"
string(42) "===== 二进制转换成八进制数 ====="
string(2) "50"
string(2) "53"
string(2) "55"
string(42) "===== 二进制转换成十进制数 ====="
int(40)
int(43)
int(45)
string(33) "===== 任意进制数转换 ====="
string(6) "000012"
string(6) "000100"
string(6) "eGLWXW"
string(6) "eFRw0s"
```
