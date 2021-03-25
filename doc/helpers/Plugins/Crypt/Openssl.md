# 助手类 Openssl ： openssl加密和解密封装
- 加密功能 ： encrypt($content, $subLength = 117)
- 解密功能 ： decrypt(string $crypt)
- 需要配置公钥、私钥、密码

## test代码

```php
$publicKey  = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDW/gKBeMa5k9Zus9QWE3rSNSqH
06Dua1lWvc9So5YxQh8ozZknZAU1FjQFHUoZZ75+lr4tN5Ln/RaxEejnkYfcWa2b
ofBEY1XRsTnDBDzAguArQXSSnmU3LLRhPyVS1io8SbNU5ersM7kTlP00pRBy7yZ/
Cqgd58Qsw48GVoDtOQIDAQAB
-----END PUBLIC KEY-----';
$privateKey = '-----BEGIN RSA PRIVATE KEY-----
MIICXgIBAAKBgQDW/gKBeMa5k9Zus9QWE3rSNSqH06Dua1lWvc9So5YxQh8ozZkn
ZAU1FjQFHUoZZ75+lr4tN5Ln/RaxEejnkYfcWa2bofBEY1XRsTnDBDzAguArQXSS
nmU3LLRhPyVS1io8SbNU5ersM7kTlP00pRBy7yZ/Cqgd58Qsw48GVoDtOQIDAQAB
AoGBAJi2ZWFCQSag9Lg91HC59YxLZ6KDmNTCO/t5aELzIERtC2UYZamtSmWjF+Bq
JbBWGOIigYPs7dUL2Yp9hkq2/SEiheCwVj1hOAO/ZcDgoZf10Zlc/Vb5ZmSVNIsG
4SVZ6VA1GH6PizQK3/Qlh2oHiTiTs7f9ZrDbnWZBlaVR9WJhAkEA9ihxbZA8ah+b
LFzxiLwKeg8f2QFFf3nXguvSKlbtJ1td6/q8dP7hrnrkoD7S20Id4c7nFaMuER9S
jZn5lYpLAwJBAN+WkZmRGMg3jKmATDvrCnY4eoAJyEQyWMfH8RSmvEozmlEAxOsr
z/msLF/OFxezftG0+N6LsxIATiPatBvAdBMCQH6DjMCl+BcHBYbIgi8nji7rpQ+w
Mprw8U3NjCfMo3it4djN9pwe/7jgWq7tewvLsHYFFAmv45ZTReeXMoqkGCcCQQCk
feqaVyQrUKrcnPX48v+cYArHnerHOV8Vg6R6c/x8fqBeTbmR5oa4gZGX3lAg8L4x
W/noCFDywmS6fhEZhaofAkEAgOES0/ix0oF9NikXEVShRWHvEMa3oZLJHm1V0ZwH
BCKtMzLPNa8zyvfr4zKU5wLSoe14F1iAzJ2ldnusiyI2lw==
-----END RSA PRIVATE KEY-----';

$openssl = Openssl::getInstance([
    'privateKey' => $privateKey,
    'publicKey'  => $publicKey,
]);
$string = [
    'name' => 'qingbing',
    'sex'  => 'nan',
    'info' => [
        'age' => 12
    ]
];

$encrypted = $openssl->encrypt($string);
var_dump($encrypted);
$decrypted = $openssl->decrypt($encrypted, true);
var_dump($decrypted);
```

## test结果

```php
string(172) "hW5/S2OFYvdRea9MMtVCfzJk9Tm0JNpEkwPuj0nU/lZGPAeEXwdfzMYMtLOtt2eIVbDQxPoKOMKq3KgBy0xLFBv1Vj5DE28AV0p7WdUjlfJW6a0Q6qQ6rG38jHEYIINh2xDR7YAWlMr+89eGZFtNbLAPMRUGT8iHvvd8ca8/0G4="
array(3) {
  ["name"]=>
  string(8) "qingbing"
  ["sex"]=>
  string(3) "nan"
  ["info"]=>
  array(1) {
    ["age"]=>
    int(12)
  }
}

```

## 边缘 : 如何生成公私钥

### 1. 安装 openssl
### 2. 利用 openssl 生成无密码钥匙

```
# 生成一个无密码私钥
openssl genrsa -out rsa_private.key 1024

# 利用私钥生成公钥
openssl rsa -in rsa_private.key -pubout -out rsa_public.key
```

### 3. 利用 openssl 生成密码钥匙
```
# 生成RSA私钥(使用aes256加密),passout 代替shell 进行密码输入，否则会提示输入密码
openssl genrsa -aes256 -passout pass:111111 -out rsa_aes_private.key 1024

# 利用私钥生成公钥,passout 代替shell 进行密码输入，否则会提示输入密码
openssl rsa -in rsa_aes_private.key -passin pass:111111 -pubout -out rsa_public.key
```
