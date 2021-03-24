# 助手类 Timer ： 记时器
- 开启一个timer ： begin($type = 'app')
- 结束timer并获取一个timer存活的时间 ： end($type = 'app')
- 获取当前的浮点型时间 ： microtime()


## test 代码

```php
Timer::begin();
Timer::begin('new');
var_dump(Timer::microTime());
var_dump(Timer::end('new'));
var_dump(Timer::end());
```

## test 结果

```php
float(1616569725.7851)
string(8) "0.000025"
string(8) "0.000049"
```
