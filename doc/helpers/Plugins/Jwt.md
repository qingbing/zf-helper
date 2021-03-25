# 助手类Jwt ： 无状态的json-web-token
- 通用函数
    - 默认设置的类型集合 ： types()
    - 错误代码消息集合 ： errors()
- 设置数据获取token
    - 清空数据map（如果jwt组件重复使用，新开一个数据时调用） ： clearMap()
    - 添加一组键值对 ： addClaims(array $claims)
    - 添加一个键值对 ： addClaim(string $name, $val = null)
    - 设置发布者 ： issuedBy(string $val)
    - 设置接受者 ： permittedFor(string $val)
    - 设置创建时间，时间戳 ： issuedAt(int $val)
    - 设置过期时间，时间戳 ： expiresAt(int $val)
    - 设置生效时间，时间戳 ： canOnlyBeUsedAfter(int $val)
    - 设置唯一标识 ： identifiedBy($val)
    - 获取数据token ： getToken()
- 解析token获取数据
    - 校验token ： verifyToken(string $token, bool $needValid = true, array $validData = []): bool
    - 获取token解析错误代码 ： getError(): int
    - 获取token解析错误内容 ： getErrorMsg(): string
    - 记录错误 ： addError(int $code, ?string $key = null): bool
    - 获取存储的数据 ： getClaims(): array
    - 获取一个指定的存储数据 ： getClaim(string $name)
    - 获取发布者 ： getIssuedBy(): ?string
    - 获取接受者 ： getPermittedFor(): ?string
    - 获取创建时间，时间戳 ： getIssuedAt(): ?int
    - 获取过期时间，时间戳 ： getExpiresAt(): ?int
    - 获取生效时间，时间戳 ： getCanOnlyBeUsedAfter(): ?int
    - 获取唯一标识 ： getIdentifiedBy()


## test 代码

```php

 $publicKey  = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCXHTK2NL0eTc+amuddhLXSkuOM
PqiTBk+bOvjz353+VsrAqRVki4YQsCGNLFypoU32zlC5GmTKU/AYyOwv43QQhOhY
98w0yZjWJL/TC6Mdx+ZYvx9NgghoeylJymC5OBKuwFZcl4RkEqxW/nn60fDeujTJ
MUNpDXF4zl8QpPEaaQIDAQAB
-----END PUBLIC KEY-----';
 $privateKey = '-----BEGIN RSA PRIVATE KEY-----
Proc-Type: 4,ENCRYPTED
DEK-Info: AES-256-CBC,464D33E943AD1FA86D6CA135DB234DB9

MlkyiHMwd4fsS62vUYYUVsPIai8sPeJYUkPoJtZ17HV00uCFEMQ1Z9fCkSYLTqrc
8p/K9VAzqY2WIh/DTxzI9iTmY4L56GeQZt2OJPQNJtGi3tQp+WBwKwF1EIGM9MLH
unBDdjVAx2pavWZvf1U8ea/UnklaNwo+7rrwhmBsxwm46V1bY2JCViqtzIJlIhJv
jjFseHRSHZ1/SNGCr5zHVeE7PhkmpX1mGIjfNGDgQLE48kTmRSVdtbeuoVtxqGIX
o/dp6da2VuRWn5ma25mgoN1VViW1B5bqOdEUtJHpFrwZWhfKlsyDzgfeOn5MsBZh
zkwqwYa6RkP32DGMCukMg0mWhPqSn1OQ9UN3dMiB2sHPG5h8kD3zJ3HS1eZ1iqT/
qrRI/3bLc6W7BJon+6v0BpWVuzI7FK6Ycp9fyrdUCljAT2s6GVXEEZHOHDovB37s
RC07Cd8FOgqKSUbwcuKs2kfM0MZLJCjaVEzsArb9KAToPxoMFKFDKKCdpJu9Nz7B
cBNgFJju5ixyAb0GzR8u7C3HN7vUZFbaDHf0q3eU/uFGLOWzB7R+nmMFt+m6I7cQ
rGo8WJGJQmuGZFLrpfIpohDueXBbtJIvM40eRP207BQV4hwZMK4xpdIs5UgxuKep
fpyrwFG6siZftacup6LzhdK2djgme0jW4t6Y2U4HuMdbwYOs7sz0lvUYHGQG6i7o
oy9UgOqyg3tJmDAm3wpkx/c6gfSbnSsqkOj7gPwZDeJRd/rhzndRjY+hcxPMIbk9
BafpJj/HGccrzMVkoH1K4QcghVeby714k4+dhmk6Zi5QsAmarD463MreESdvoVmg
-----END RSA PRIVATE KEY-----';

// 组件实例化
$jwt = Jwt::getInstance([
    'privateKey' => $privateKey,
    'publicKey'  => $publicKey,
    'passphrase' => '1qaz@WSX'
]);
// 数据设置并获取token
$token = $jwt->issuedBy("admin")
    ->expiresAt(time() - 1)
    ->issuedAt(time() + 30)
    ->canOnlyBeUsedAfter(time() - 5)
    ->getToken();
var_dump($token);
// 数据校验和获取数据
$status = $jwt->verifyToken($token, true, [
    'ip' => '127.0.0.1',
]);
if (false === $status) {
    var_dump('Error Code : ' . $jwt->getError());
    var_dump('Error Msg : ' . $jwt->getErrorMsg());
} else {
    var_dump($jwt->getClaims());
}
var_dump('===============');

// 数据设置并获取token
$token = $jwt
    ->clearMap()
    ->issuedBy("admin")
    ->expiresAt(time() + 5)
    ->issuedAt(time() + 30)
    ->canOnlyBeUsedAfter(time() - 5)
    ->addClaim('ip', '127.0.0.1')
    ->getToken();
var_dump($token);
// 数据校验和获取数据
$status = $jwt->verifyToken($token, true, [
    Jwt::TYPE_ISSUED_BY => "admin",
]);
if (false === $status) {
    var_dump('Error Code : ' . $jwt->getError());
    var_dump('Error Msg : ' . $jwt->getErrorMsg());
} else {
    var_dump($jwt->getClaim('iat'));
    var_dump($jwt->getClaims());
    var_dump($jwt->getExpiresAt());
}
```

## test 结果

```php

string(175) "i3MlFHlfLrSd01Ego8Ur1RNDEQcVb8NLGIARO7PkPUd6I6B4rg7haPZgYV5hCTKocWnYzzdyCKSB00Z6hyTa4BTo8mWvodT9ckGKs7YpAkvFs2iRt4Wwpsj3wxA7rhTxkKgNA8MVhPued2UEqNAxSokzTawoIbOGYYLDWkU2NrGJw03"
string(14) "Error Code : 2"
string(26) "Error Msg : TOKEN已过期"
string(15) "==============="
string(370) "QrJaRKgoPNsRFq6YUe02RaWIVkt7iJO5OS027lUd8Zbq8eVKcY1csyuGSfnd02600XCdKeNg0100Sb3k91T60180254uonVTAZy02qhKrjBDR6HBbq1BfcCWjS00YvsxhhVTval6004ENFk029fPGJPVKCL5aCJa4F01U1T00nBjcphJI2gGGUQkpYVx25yWqfiEE9inuq9D59z018E3Uf83Kj01qus6TcQKO54wA1ILlZZQ47UoT7oahhZ2UMZIr102vtspOwiZiElE6tkfsw00xCVlFaQmfI7XukwcKvzLOFJ3C202gbTHGdrarcR9gox00v01UI02tO00xyI1qjXZhwERrNg4QkbRh025wj5dbw0303"
int(1616660041)
array(5) {
  ["iss"]=>
  string(5) "admin"
  ["exp"]=>
  int(1616660016)
  ["iat"]=>
  int(1616660041)
  ["nbf"]=>
  int(1616660006)
  ["ip"]=>
  string(9) "127.0.0.1"
}
int(1616660016)

```


