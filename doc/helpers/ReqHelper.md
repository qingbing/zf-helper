# 请求助手类 ReqHelper ： 请求获取类
- 获取当前的请求的Trace-ID ： getTraceId(): string
- 判断是否是在cli模式下运行 ： isCli(): bool
- 获取 accept-types,发送端希望接受的数据类型 ： acceptTypes()
- 返回链接的请求类型 ： requestMethod(): string
- 获取请求的Uri ： requestUri(): string
- 获取请求的"query"部分 ： queryString(): string
- 判断请求是否是ajax ： isAjaxRequest(): bool
- 返回访问链接是否为安全链接(https) ： isSecureConnection(): bool
- 获取 http 访问端口 ： serverPort()
- 返回主机名 ： host(): string
- 获取用户IP地址 ： userHostAddress(): string
- 获取 URL 来源 ： urlReferrer()
- 获取用户访问客户端信息 ： userAgent()
- 获取普通访问链接的端口 ： getPort()
- 获取安全链接（https）的端口 ： getSecurePort()


## test 代码

```php
var_dump('getTraceId : ' . ReqHelper::getTraceId());
var_dump('acceptTypes : ' . ReqHelper::acceptTypes());
var_dump('requestMethod : ' . ReqHelper::requestMethod());
var_dump('requestUri : ' . ReqHelper::requestUri());
var_dump('queryString : ' . ReqHelper::queryString());
var_dump('isAjaxRequest : ' . ReqHelper::isAjaxRequest());
var_dump('isSecureConnection : ' . ReqHelper::isSecureConnection());
var_dump('serverPort : ' . ReqHelper::serverPort());
var_dump('host : ' . ReqHelper::host());
var_dump('userHostAddress : ' . ReqHelper::userHostAddress());
var_dump('urlReferrer : ' . ReqHelper::urlReferrer());
var_dump('userAgent : ' . ReqHelper::userAgent());
var_dump('getPort : ' . ReqHelper::getPort());
var_dump('getSecurePort : ' . ReqHelper::getSecurePort());
```

## test 结果

```php
string(43) "getTraceId : 605ae2dcc0a80109fff705ae2dc3f34b"
string(149) "acceptTypes : text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9"
string(19) "requestMethod : GET"
string(18) "requestUri : /test"
string(14) "queryString : "
string(16) "isAjaxRequest : "
string(21) "isSecureConnection : "
string(15) "serverPort : 80"
string(21) "host : program.yii.us"
string(29) "userHostAddress : 192.168.1.1"
string(14) "urlReferrer : "
string(132) "userAgent : Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36"
string(12) "getPort : 80"
string(19) "getSecurePort : 443"
```

