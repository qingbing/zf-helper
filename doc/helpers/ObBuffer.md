# 助手类 ObBuffer ： Ob缓冲管理
- 开始缓冲区 ： start()
- 结束缓冲区 ： end($return = true)

## test 代码

```php
ObBuffer::start();
var_dump(111);
$output = ObBuffer::end();

// 页面输出
var_dump(222);
// 将缓冲内容输出
echo $output;
```
