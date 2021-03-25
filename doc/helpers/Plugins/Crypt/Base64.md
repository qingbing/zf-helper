# 助手类 Base64 ： base64对数据加密
- base64数据加密 ： encrypt(?string $val): string
- base64数据解密 ： decrypt(?string $val): string

## test 代码

```php
$string = " My name is qingbing! 哈哈 👌";
var_dump($string);
$code = Base64::encrypt($string);
var_dump($code);
$newString = Base64::decrypt($code);
var_dump($newString);
```

## test 结果

```php
string(33) " My name is qingbing! 哈哈 👌"
string(44) "IE15IG5hbWUgaXMgcWluZ2JpbmchIOWTiOWTiCDwn5GM"
string(33) " My name is qingbing! 哈哈 👌"
```
