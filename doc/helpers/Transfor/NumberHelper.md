# 辅助类 NumberHelper : 数据进制转化
- static decToBase(int $n, int $base, $length = 0) : 十进制数转化任意进制数，不能大于 65
- static binaryToOctal(string $code) : 二进制转换成八进制数
- static binaryToDec(string $code) : 二进制转换成十进制数
- static binaryToHex(string $code) : 二进制转换成十六进制数
- static binaryToBase64(string $code) : 二进制转换成64进制
- static octalToBinary(string $code) : 八进制转换成二进制数
- static octalToDec(string $code) : 八进制转换成十进制数
- static octalToHex(string $code) : 八进制转换成十六进制数
- static octalToBase64(string $code) : 八进制转换成64进制数
- static decToBinary($n, int $length = 0) : 十进制转换成二进制数
- static decToOctal($n) : 十进制转换成八进制数
- static decToHex($n) : 十进制转换成十六进制数
- static decToBase64($n) : 十进制转换成64进制数
- static hexToBinary(string $code) : 十六进制转换成二进制数
- static hexToOctal(string $code) : 十六进制转换成八进制数
- static hexToDec(string $code) : 十六进制转换成十进制数
- static hexToBase64(string $code) : 十六进制转换成64进制数
- static base64ToBinary(string $code) : 64进制转换成二进制
- static base64ToOctal(string $code) : 64进制转换成八进制
- static base64ToDec(string $code) : 64进制转换成十进制
- static base64ToHex(string $code) : 64进制转换成十六进制

## test 代码

```php
// 十进制数转化任意进制数，不能大于 65
var_dump('===== 十进制数转化任意进制数，不能大于 65 =====');
var_dump(NumberHelper::decToBase(64, 62, 6));
var_dump(NumberHelper::decToBase(3844, 62, 6));
var_dump(NumberHelper::decToBase(13457893844, 62, 6));
var_dump(NumberHelper::decToBase(13444443844, 62, 6));

// 二进制转换成十六进制数
var_dump('===== 二进制转换成十六进制数 =====');
var_dump(NumberHelper::binaryToHex(101000));
var_dump(NumberHelper::binaryToHex(101011));
var_dump(NumberHelper::binaryToHex(101101));
// 二进制转换成八进制数
var_dump('===== 二进制转换成八进制数 =====');
var_dump(NumberHelper::binaryToOctal(101000));
var_dump(NumberHelper::binaryToOctal(101011));
var_dump(NumberHelper::binaryToOctal(101101));
// 二进制转换成十进制数
var_dump('===== 二进制转换成十进制数 =====');
var_dump(NumberHelper::binaryToDec(101000));
var_dump(NumberHelper::binaryToDec(101011));
var_dump(NumberHelper::binaryToDec(101101));
// 二进制转换成64进制
var_dump('===== 二进制转换成64进制 =====');
var_dump(NumberHelper::binaryToBase64(101000));
var_dump(NumberHelper::binaryToBase64(101011));
var_dump(NumberHelper::binaryToBase64(101101));

// 八进制转换成十进制数
var_dump('===== 八进制转换成十进制数 =====');
var_dump(NumberHelper::octalToHex(23));
var_dump(NumberHelper::octalToHex(1073));
var_dump(NumberHelper::octalToHex(6532));
// 八进制转换成十进制数
var_dump('===== 八进制转换成十进制数 =====');
var_dump(NumberHelper::octalToDec(23));
var_dump(NumberHelper::octalToDec(1073));
var_dump(NumberHelper::octalToDec(6532));
// 八进制转换成二进制数
var_dump('===== 八进制转换成二进制数 =====');
var_dump(NumberHelper::octalToBinary(23));
var_dump(NumberHelper::octalToBinary(1073));
var_dump(NumberHelper::octalToBinary(6532));
// 八进制转换成64进制数
var_dump('===== 八进制转换成64进制数 =====');
var_dump(NumberHelper::octalToBase64(23));
var_dump(NumberHelper::octalToBase64(1073));
var_dump(NumberHelper::octalToBase64(6532));

// 十进制转换成十六进制数
var_dump('===== 十进制转换成十六进制数 =====');
var_dump(NumberHelper::decToHex(28));
var_dump(NumberHelper::decToHex(1073));
var_dump(NumberHelper::decToHex(6532));
// 十进制转换成八进制数
var_dump('===== 十进制转换成八进制数 =====');
var_dump(NumberHelper::decToOctal(23));
var_dump(NumberHelper::decToOctal(1073));
var_dump(NumberHelper::decToOctal(6532));
// 十进制转换成二进制数
var_dump('===== 十进制转换成二进制数 =====');
var_dump(NumberHelper::decToBinary(23));
var_dump(NumberHelper::decToBinary(1073));
var_dump(NumberHelper::decToBinary(6532));
// 十进制转换成64进制数
var_dump('===== 十进制转换成64进制数 =====');
var_dump(NumberHelper::decToBase64(23));
var_dump(NumberHelper::decToBase64(1073));
var_dump(NumberHelper::decToBase64(6532));

// 十六进制转换成十进制数
var_dump('===== 十六进制转换成十进制数 =====');
var_dump(NumberHelper::hexToDec('1C'));
var_dump(NumberHelper::hexToDec('431'));
var_dump(NumberHelper::hexToDec('1984'));
// 十六进制转换成八进制数
var_dump('===== 十六进制转换成八进制数 =====');
var_dump(NumberHelper::hexToOctal('1C'));
var_dump(NumberHelper::hexToOctal('431'));
var_dump(NumberHelper::hexToOctal('1984'));
// 十六进制转换成十六进制数
var_dump('===== 十六进制转换成十六进制数 =====');
var_dump(NumberHelper::hexToBinary('1C'));
var_dump(NumberHelper::hexToBinary('431'));
var_dump(NumberHelper::hexToBinary('1984'));
// 十六进制转换成十六进制数
var_dump('===== 十六进制转换成十六进制数 =====');
var_dump(NumberHelper::hexToBinary('1C'));
var_dump(NumberHelper::hexToBinary('431'));
var_dump(NumberHelper::hexToBinary('1984'));

// 64进制转换成二进制
var_dump('===== 64进制转换成二进制 =====');
var_dump(NumberHelper::base64ToBinary('-'));
var_dump(NumberHelper::base64ToBinary('10'));
var_dump(NumberHelper::base64ToBinary('20'));
// 64进制转换成八进制
var_dump('===== 64进制转换成八进制 =====');
var_dump(NumberHelper::base64ToOctal('-'));
var_dump(NumberHelper::base64ToOctal('10'));
var_dump(NumberHelper::base64ToOctal('20'));
// 64进制转换成十进制
var_dump('===== 64进制转换成十进制 =====');
var_dump(NumberHelper::base64ToDec('-'));
var_dump(NumberHelper::base64ToDec('10'));
var_dump(NumberHelper::base64ToDec('20'));
// 64进制转换成十六进制
var_dump('===== 64进制转换成十六进制 =====');
var_dump(NumberHelper::base64ToHex('-'));
var_dump(NumberHelper::base64ToHex('10'));
var_dump(NumberHelper::base64ToHex('20'));
```

## test 结果

```text
string(63) "===== 十进制数转化任意进制数，不能大于 65 ====="
string(6) "000012"
string(6) "000100"
string(6) "eGLWXW"
string(6) "eFRw0s"
string(45) "===== 二进制转换成十六进制数 ====="
string(2) "28"
string(2) "2b"
string(2) "2d"
string(42) "===== 二进制转换成八进制数 ====="
string(2) "50"
string(2) "53"
string(2) "55"
string(42) "===== 二进制转换成十进制数 ====="
int(40)
int(43)
int(45)
string(38) "===== 二进制转换成64进制 ====="
string(1) "E"
string(1) "H"
string(1) "J"
string(42) "===== 八进制转换成十进制数 ====="
string(2) "13"
string(4) "023b"
string(4) "0d5a"
string(42) "===== 八进制转换成十进制数 ====="
int(19)
int(571)
int(3418)
string(42) "===== 八进制转换成二进制数 ====="
string(8) "00010011"
string(16) "0000001000111011"
string(16) "0000110101011010"
string(41) "===== 八进制转换成64进制数 ====="
string(2) "0j"
string(3) "08X"
string(3) "0Rq"
string(45) "===== 十进制转换成十六进制数 ====="
string(2) "1c"
string(3) "431"
string(4) "1984"
string(42) "===== 十进制转换成八进制数 ====="
string(2) "27"
string(4) "2061"
string(5) "14604"
string(42) "===== 十进制转换成二进制数 ====="
string(8) "00010111"
string(16) "0000010000110001"
string(16) "0001100110000100"
string(41) "===== 十进制转换成64进制数 ====="
string(1) "n"
string(2) "gN"
string(3) "1C4"
string(45) "===== 十六进制转换成十进制数 ====="
int(28)
int(1073)
int(6532)
string(45) "===== 十六进制转换成八进制数 ====="
string(3) "034"
string(6) "002061"
string(6) "014604"
string(48) "===== 十六进制转换成十六进制数 ====="
string(8) "00011100"
string(16) "0000010000110001"
string(16) "0001100110000100"
string(48) "===== 十六进制转换成十六进制数 ====="
string(8) "00011100"
string(16) "0000010000110001"
string(16) "0001100110000100"
string(38) "===== 64进制转换成二进制 ====="
string(8) "00111111"
string(8) "01000000"
string(8) "10000000"
string(38) "===== 64进制转换成八进制 ====="
string(3) "077"
string(3) "100"
string(3) "200"
string(38) "===== 64进制转换成十进制 ====="
int(63)
int(64)
int(128)
string(41) "===== 64进制转换成十六进制 ====="
string(2) "3f"
string(2) "40"
string(2) "80"
```
