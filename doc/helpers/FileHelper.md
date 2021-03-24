# 助手类 FileHelper ： 文件目录处理
- 拷贝文件 ： cpFile(string $src, string $dst, $newFileMode = null)
- 删除文件 ： unlink(string $file): bool
- 获取文件中的内容 ： getContent(string $file)
- 将字符串写入文件中 ： putContent(string $file, $content, $append = true)
- 创建文件夹 ： mkdir(string $dst, $mode = 0777, $recursive = false): bool
- 删除文件夹 ： rmdir(string $dir, $recursive = false): bool
- 复制目录 ： cpDir(string $src, string $dst, array $options = [])

## test 代码

```php
$runtimePath = \Yii::$app->getRuntimePath();
$file        = $runtimePath . "/test.log";
// 拷贝文件
FileHelper::cpFile($file, $runtimePath . "/xxx.log");

// 删除文件
FileHelper::unlink($runtimePath . "/xxx.log");

// 获取文件内容
$content = FileHelper::getContent($file);
var_dump($content);

// 写入文件内容
FileHelper::putContent($file, "哎呀\n");

// 创建文件夹
FileHelper::mkdir($runtimePath . "/good/test/xx/xxx", 0777, true);

// 删除文件夹
$status = FileHelper::rmdir($runtimePath . "/good/test", true);
var_dump($status);

// 复制目录
FileHelper::cpDir($runtimePath . "/cache", $runtimePath . "/cache11");
```
