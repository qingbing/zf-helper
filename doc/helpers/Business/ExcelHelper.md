# 助手类 ExcelHelper ： excel装填下载
- 继承 \Zf\Helper\Abstracts\Factory
- 对外提供方法
    - getActiveSheet() ： 获取当前操作工作表
    - setActiveSheetIndex(int $activeSheetIndex) ： 设置操作工作表的索引
    - getTitle() ： 获取工作表名称
    - setTitle(?string $title = null) ： 设置工作表名称
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

```php

// 下载准备
$excel = ExcelHelper::getInstance()
    ->setTitle('test')
    ->setActiveSheetIndex(0);
// 数据装填并下载
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
            'value'   => 'name24',
            'colspan' => 3,
        ]
    ]
], true)
    ->writeLine([
        "key1" => "data1",
        "key2" => "data2",
        "key3" => "data3",
        "key4" => "data4",
    ])
    ->writeData([
        ["key1" => "data1", "key2" => "data2", "key3" => "data3", "key4" => "data4",],
        ["key1" => "data1", "key3" => "data333", "key4" => "data4", "key2" => "data2",],
    ])
    ->writeLine([
        "key1" => "data1",
        "key2" => "data2",
        "key3" => "data3",
        "key4" => "data4",
    ])->download();

```
