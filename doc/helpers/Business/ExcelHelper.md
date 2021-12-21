# 助手类 ExcelHelper ： excel装填下载
- 继承 \Zf\Helper\Abstracts\Factory
- 对外提供方法
    - setNumberToText(bool $value) : 设置是否所有数字展示都转换文本
    - getNumberToText() ： 获取是否所有数字展示都转换文本
    - getActiveSheet() ： 获取当前操作工作表
    - addSheet(?string $title = null, bool $noDefault = false, ?string $key = null) ： 增加sheet
    - setActiveSheetIndex($key) ： 设置操作工作表的索引，addSheet 中的 $key 或 0～...
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

## 使用说明
- 该类主要使用 phpoffice/phpspreadsheet 作为基础支持
- 在 phpoffice/phpspreadsheet 中，可能有用方法
    - setCellValue('B8','=IF(C4>500,"profit","loss")'): 向表格插入公式，以"="开始即可
    - setCellValueExplicit($cell, $value, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2): 明确内容格式
    - getStyle('B2'): 表格支持范围，比如: A1:A100, A1:B200
    - 换行
        - $spreadsheet->getActiveSheet()->getCell('A1')->setValue("hello\nworld");
        - $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setWrapText(true)
    - 设置超链接
        - $spreadsheet->getActiveSheet()->getCell('E26')->getHyperlink()->setUrl('https://www.example.com');
    - 设置字体颜色
        - $spreadsheet->getActiveSheet()->getStyle('B2')
                      ->getFont()
                      ->getColor()
                      ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
    - 设置对齐方式
        - $spreadsheet->getActiveSheet()->getStyle('B2')
                      ->getAlignment()
                      ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
    - 设置border样式
        - $spreadsheet->getActiveSheet()->getStyle('B2')
                      ->getBorders()
                      //->getTop()
                      //->getBottom()
                      //->getLeft()
                      //->getRight()
                      ->getTop()
                      ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
    - 设置填充样式
        - $spreadsheet->getActiveSheet()->getStyle('B2')
                      ->getFill()
                      ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        - $spreadsheet->getActiveSheet()->getStyle('B2')
                      ->getFill()
                      ->getStartColor()
                      ->setARGB('FFFF0000')
    - 设置数字保留小数并填充
        - $spreadsheet->getActiveSheet()->getStyle('A1')
                       ->getNumberFormat()
                       ->setFormatCode('#,##0.00');
    - 四位补0填充
         - $spreadsheet->getActiveSheet()->getStyle('A1')
                        ->getNumberFormat()
                        ->setFormatCode('0000'); (19 => 0019)
    - 自动换行
        - $spreadsheet->getActiveSheet()->getStyle('A1:D4')
          ->getAlignment()->setWrapText(true)
    - 垂直对齐
        - $spreadsheet->getActiveSheet()->getStyle('A1:D4')
                        ->getAlignment()
                        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP)
    - 工作表默认样式
        - $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
        - $spreadsheet->getDefaultStyle()->getFont()->setSize(8);
    - 复制单元格样式
        - $spreadsheet->getActiveSheet()
                    ->duplicateStyle(
                        $spreadsheet->getActiveSheet()->getStyle('B2'),
                        'B3:B7'
                    );
    - 合并单元格
        - $spreadsheet->getActiveSheet()
                    ->mergeCells('A18:E22');
    - 取消合并单元格
        - $spreadsheet->getActiveSheet()
                    ->unmergeCells('A18:E22');
    - 设置列的宽度
        - $spreadsheet->getActiveSheet()
                    ->getColumnDimension('D')
                    ->setWidth(12); // 固定宽度
        - $spreadsheet->getActiveSheet()
                    ->getColumnDimension('B')
                    ->setAutoSize(true); // 自动宽度
    - 设置行的高度
        - $spreadsheet->getActiveSheet()
                    ->getRowDimension('10')
                    ->setRowHeight(100);
    - 设置默认列宽
        - $spreadsheet->getActiveSheet()
                    ->getDefaultColumnDimension()
                    ->setWidth(12);
    - 设置默认行高
        - $spreadsheet->getActiveSheet()
                    ->getDefaultRowDimension()
                    ->setRowHeight(15);
    
    

## 测试代码
```php

$excel = ExcelHelper::getInstance()
    ->setTitle('excel文件文件名')
    ->setNumberToText(false);
$excel->addSheet('test1', false, 'test1')
    ->writeMergeData([
        [
            'key1' => 'name11',
            'key2' => 'name21',
            'key3' => [
                'value'   => 'name31-41',
                'colspan' => 2,
                'horizontal'    => ExcelHelper::HORIZONTAL_LEFT,
                'rowHorizontal' => ExcelHelper::HORIZONTAL_RIGHT,
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
    ], false)
    //->setHeaders([
        //'key1' => 'name11',
        //'key2' => 'name21',
    //])
    ->writeData([
        [
            'key1' => 'name11',
            'key2' => 'name21',
            'key3' => '哎呀问我',
        ],
        [
            'key1' => 'name11',
            'key2' => 'name21',
            'key3' => '哎呀问我',
        ],
    ]);
$excel->addSheet('test12', false, 'test12')
    ->setHeaders([
        'key1' => 'xxx',
        'key2' => 'yyy',
    ])
    ->writeData([
        [
            'key1' => 'name11',
            'key2' => 'name21',
        ],
        [
            'key1' => 'name11',
            'key2' => 'name21',
        ],
    ]);
$excel->setActiveSheetIndex('test1')
    ->setHeaders([
        'key1' => [
            'value'         => '哎呀',
            'horizontal'    => ExcelHelper::HORIZONTAL_CENTER,
            //'rowHorizontal' => ExcelHelper::HORIZONTAL_RIGHT,
        ],
        'key2' => [
            'value'         => '来吧',
            //'rowHorizontal' => ExcelHelper::HORIZONTAL_CENTER,
        ],
    ])
    ->writeData([
        [
            'key1' => 'sdfsdf',
            'key2' => 'name21',
        ],
        [
            'key1' => 'name11',
            'key2' => 'name21',
        ],
    ]);
    
$excel->addSheet('test数字')
    ->setHeaders([
        'key1' => '字段1',
        'key4' => '字段4',
        'key2' => '字段2',
        'key3' => '字段3',
    ])
    ->writeData([
        ['key1' => '1', 'key2' => '000111', 'key3' => '', 'key4' => 'key4',],
        ['key1' => '12', 'key2' => '0212', 'key3' => '', 'key4' => 'key4',],
        ['key1' => '123', 'key2' => '', 'key3' => '', 'key4' => 'key4',],
        ['key1' => '1234', 'key2' => '', 'key3' => '', 'key4' => 'key4',],
        ['key1' => '12345', 'key2' => '', 'key3' => '', 'key4' => 'key4',],
        ['key1' => '123456', 'key2' => '', 'key3' => '', 'key4' => 'key4',],
        ['key1' => '1234567', 'key2' => '', 'key3' => '', 'key4' => 'key4',],
        ['key1' => '12345678', 'key2' => '', 'key3' => '', 'key4' => 'key4',],
        ['key1' => '123456789', 'key2' => '', 'key3' => '', 'key4' => 'key4',],
        ['key1' => '1234567890', 'key2' => '', 'key3' => '', 'key4' => 'key4',],
        ['key1' => '12345678901', 'key2' => '', 'key3' => '', 'key4' => 'key4',],
        ['key1' => '123456789012', 'key2' => '', 'key3' => '', 'key4' => 'key4',],
        ['key1' => '1234567890123', 'key2' => '', 'key3' => '', 'key4' => 'key4',],
        ['key1' => '12345678901234', 'key2' => '', 'key3' => '', 'key4' => 'key4',],
        ['key1' => '123456789012345', 'key2' => '', 'key3' => '', 'key4' => 'key4',],
        ['key1' => '1234567890123456', 'key2' => '', 'key3' => '', 'key4' => 'key4',],
        ['key1' => '12345678901234567', 'key2' => '', 'key3' => '', 'key4' => 'key4',],
        ['key1' => '123456789012345678', 'key2' => '', 'key3' => '', 'key4' => 'key4',],
        ['key1' => '1234567890123456789', 'key2' => '', 'key3' => '', 'key4' => 'key4',],
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
