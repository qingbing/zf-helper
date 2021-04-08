# 助手类 DataStore ： 数据容器
- 获取登记信息 ： get(string $name, $default = null)
- 设置登记信息 ： set(string $name, $value = null)
- 删除一个登记信息 ： del(string $name): bool
- 检测是否存在 ： has(string $name): bool

## test 代码

```php
// 设置
DataStore::set("name", "qingbing");
// 获取
var_dump(DataStore::get("name", 'xx'));
// 判断是否包含
var_dump(DataStore::has("name"));
// 删除
var_dump(DataStore::del("name"));
var_dump(DataStore::has("name"));
```

## test 结果

```php
string(8) "qingbing"
bool(true)
bool(true)
bool(false)
```
