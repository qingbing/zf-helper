# 助手类 Object ： 类或Object处理
- 创建类实例 ： create($config)
- 获取类反射 ： getReflection($class)

## test 代码
```php

class demo
{
    use TConfigure;
    protected $name;
    public    $sex;
    private   $age;
}


$obj = Obj::create([
    'class' => demo::class,
]);
var_dump($obj);
$reflection = Obj::getReflection($obj);
var_dump($reflection);
```

## test 结果

```php
object(app\controllers\demo)#77 (3) {
  ["name":protected]=>
  NULL
  ["sex"]=>
  NULL
  ["age":"app\controllers\demo":private]=>
  NULL
}
object(ReflectionClass)#78 (1) {
  ["name"]=>
  string(20) "app\controllers\demo"
}

```
