# 抽象类 Singleton ： 单例模式基类
- 整个请求生命周期，只能实例化一个类
- 获取实例 ： {class}::getInstance()
- 类不能 new
- 实例不能 clone
- 子类构造函数直接覆盖 init() 方法即可

```php
// 基础基类
class demo extends Singleton
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
var_dump($demo1 === $demo2); // true
```
