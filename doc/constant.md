# 常规常量定义

```php
// 性别
defined('SEX_UNKNOWN') or define('SEX_UNKNOWN', 0);
defined('SEX_MALE') or define('SEX_MALE', 1);
defined('SEX_FEMALE') or define('SEX_FEMALE', 2);
// 是否选择
defined('IS_NO') or define('IS_NO', 0);
defined('IS_YES') or define('IS_YES', 1);
// 禁用状态
defined('IS_FORBIDDEN_NO') or define('IS_FORBIDDEN_NO', 0);
defined('IS_FORBIDDEN_YES') or define('IS_FORBIDDEN_YES', 1);
// 开启状态
defined('IS_ENABLE_NO') or define('IS_ENABLE_NO', 0);
defined('IS_ENABLE_YES') or define('IS_ENABLE_YES', 1);
// 删除状态
defined('IS_DELETED_NO') or define('IS_DELETED_NO', 0);
defined('IS_DELETED_YES') or define('IS_DELETED_YES', 1);
```

# 任何地方直接使用

```php
// 性别
var_dump(SEX_UNKNOWN); // 0
var_dump(SEX_MALE); // 1
var_dump(SEX_FEMALE); // 2
// 是否选择
var_dump(IS_NO); // 0
var_dump(IS_YES); // 1
// 禁用状态
var_dump(IS_FORBIDDEN_NO); // 0
var_dump(IS_FORBIDDEN_YES); // 1
// 开启状态
var_dump(IS_ENABLE_NO); // 0
var_dump(IS_ENABLE_YES); // 1
// 删除状态
var_dump(IS_DELETED_NO); // 0
var_dump(IS_DELETED_YES); // 1
```
