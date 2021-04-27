# 助手类 ExcelHelper ： excel装填下载
- 继承 \Zf\Helper\Abstracts\Factory
- 对外提供方法
    - setNumberToText(bool $value) : 设置是否所有数字展示都转换文本
    - getNumberToText() ： 获取是否所有数字展示都转换文本
    - getActiveSheet() ： 获取当前操作工作表
    - setActiveSheetIndex(int $activeSheetIndex) ： 设置操作工作表的索引
    - getTitle() ： 获取工作表名称
    - setTitle(?string $title = null) ： 设置工作表名称
    - setActiveSheetTitle(?string $title = null) ： 设置当前操作表的名称
    - getRowNum() ： 获取当前行索引
    - getColNum() ： 获取当前的列表
    - nextCol(?int $num = 1) ： 列标后移
    - nextRow(?int $num = 1) ： 行标后移
    - getColSign(?int $colNum = null) ： 获取 col 的字母表示
    - getCellSign(?int $colNum = null, ?int $rowNum = null) ： 获取单元格的表示代码
    - setHeaders(?array $headers = null, bool $writeExcel = true) ： 设置表头字段
    - getHeaders() ： 获取表头字段
    - writeLine(array $data) ： 书写一行数据
    - writeData(array $res = []) ： 批量书写数据
    - writeMergeData(array $records, bool $setHeader = false) ： 装填数据，支持单元格合并，同html-table一样，使用 colspan 和 rowspan 表示单元格合并的数量和方向
    - download() ： 文件excel下载
    - save(string $filePath) ： 持久化 excel 到服务器文件上
    - ::readFile(string $filePath, ?int $idx = 0) : 读取 excel 文件


## 测试代码
```php

// 下载准备
$excel = ExcelHelper::getInstance()
    ->setTitle('excel文件文件名')
    ->setNumberToText(false)
    ->setActiveSheetIndex(0);
// 获取
$excel->writeMergeData([
    [
        'key1' => 'name11',
        'key2' => 'name21',
        'key3' => [
            'value'   => 'name31-41',
            'colspan' => 2,
        ]
    ],
    [
        'key1' => [
            'value'   => 'name12',
            'rowspan' => 2,
        ],
        'key2' => [
            'value'   => 'name22',
            'colspan' => 2,
            'rowspan' => 2,
        ],
        'key4' => 'name42',
    ],
    [
        'key4' => 'name43',
    ],
    [
        'key1' => 'name14',
        'key2' => [
            'value'   => '2.120',
            'colspan' => 3,
        ]
    ]
], true)
    ->setActiveSheetTitle("测试")
    ->writeData([
        ['key1' => '1', 'key2' => '000111', 'key3' => '', 'key4' => '',],
        ['key1' => '12', 'key2' => '0212', 'key3' => '', 'key4' => '',],
        ['key1' => '123', 'key2' => '', 'key3' => '', 'key4' => '',],
        ['key1' => '1234', 'key2' => '', 'key3' => '', 'key4' => '',],
        ['key1' => '12345', 'key2' => '', 'key3' => '', 'key4' => '',],
        ['key1' => '123456', 'key2' => '', 'key3' => '', 'key4' => '',],
        ['key1' => '1234567', 'key2' => '', 'key3' => '', 'key4' => '',],
        ['key1' => '12345678', 'key2' => '', 'key3' => '', 'key4' => '',],
        ['key1' => '123456789', 'key2' => '', 'key3' => '', 'key4' => '',],
        ['key1' => '1234567890', 'key2' => '', 'key3' => '', 'key4' => '',],
        ['key1' => '12345678901', 'key2' => '', 'key3' => '', 'key4' => '',],
        ['key1' => '123456789012', 'key2' => '', 'key3' => '', 'key4' => '',],
        ['key1' => '1234567890123', 'key2' => '', 'key3' => '', 'key4' => '',],
        ['key1' => '12345678901234', 'key2' => '', 'key3' => '', 'key4' => '',],
        ['key1' => '123456789012345', 'key2' => '', 'key3' => '', 'key4' => '',],
        ['key1' => '1234567890123456', 'key2' => '', 'key3' => '', 'key4' => '',],
        ['key1' => '12345678901234567', 'key2' => '', 'key3' => '', 'key4' => '',],
        ['key1' => '123456789012345678', 'key2' => '', 'key3' => '', 'key4' => '',],
        ['key1' => '1234567890123456789', 'key2' => '', 'key3' => '', 'key4' => '',],
    ]);

// 下载客户端
$excel->download();

// 保存硬盘
$filePath = \Yii::$app->getRuntimePath() . "/xx.xlsx";
$excel->save($filePath);

// 读取excel
$data = ExcelHelper::readFile($filePath, null);
var_dump($data);
```
