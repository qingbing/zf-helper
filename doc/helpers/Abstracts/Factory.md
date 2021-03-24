# 抽象类 Factory ： 工厂模式基类
- 获取实例 ： {class}::getInstance()
- 类不能 new
- 子类构造函数直接覆盖 init() 方法即可

```php
// 基础基类
class demo extends Factory
{
    public function run()
    {
        var_dump(11);
    }
}

// 使用
$demo1 = demo::getInstance();
$demo2 = demo::getInstance();
var_dump($demo1);
var_dump($demo2);
var_dump($demo1 === $demo2); // false
```
