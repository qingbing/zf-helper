# openssl密码管理封装
- openssl 密钥生成 ： generateSecrets($passphrase = '', $priKeyBits = self::PRICATE_KEY_BIT_1024, $priKeyType = OPENSSL_KEYTYPE_RSA): array
- openssl 加密 ： encrypt(string $publicKey, $content, $subLength = 117)
- openssl 解密 ： encrypt(string $publicKey, $content, $subLength = 117)


# test 代码

```php
$passphrase = '1234';
$keys       = \Zf\Helper\Crypt\Openssl::generateSecrets($passphrase);

$data = [
    'country' => 'China',
    'name'    => 'qingbing',
    'chinese' => '中文',
];

$sign = \Zf\Helper\Crypt\Openssl::encrypt($keys['public_key'], $data);
var_dump($sign);
$deData = \Zf\Helper\Crypt\Openssl::decrypt($keys['private_key'], $sign, $passphrase);
var_dump($deData);
```

# test 结果

```php
string(180) "orNkQoQA15OyAY02dEdqRFEyN02BIt7ueYgdJ3fo2R94hunHYoCrVSjKNvy4wrXTQ7f5pPmaZcGqO94d8NUXGG00YIByuQMUxVI00SJyXo1ohhLx7JIL9dqvDULugByCzVfD2yIx008mBuNVnjJR4hMV6dmovx00MoB01XTAl1ySgTyCZ403"
array(3) {
  ["country"]=>
  string(5) "China"
  ["name"]=>
  string(8) "qingbing"
  ["chinese"]=>
  string(6) "中文"
}

```
