<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Business;


use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Reader;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Exception as WriterException;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as Writer;
use Zf\Helper\Abstracts\Factory;
use Zf\Helper\Util;

/**
 * 业务助手 ： excel装填下载
 *
 * Class ExcelHelper
 * @package Zf\Helper\Business
 */
class ExcelHelper extends Factory
{
    // 对齐方向
    const ALIGN_TYPE_HORIZONTAL = 'horizontal';
    const ALIGN_TYPE_VERTICAL   = 'vertical';
    // 垂直对齐
    const HORIZONTAL_GENERAL           = 'general';
    const HORIZONTAL_LEFT              = 'left';
    const HORIZONTAL_RIGHT             = 'right';
    const HORIZONTAL_CENTER            = 'center';
    const HORIZONTAL_CENTER_CONTINUOUS = 'centerContinuous';
    const HORIZONTAL_JUSTIFY           = 'justify';
    const HORIZONTAL_FILL              = 'fill';
    // 水平对齐
    const VERTICAL_BOTTOM  = 'bottom';
    const VERTICAL_TOP     = 'top';
    const VERTICAL_CENTER  = 'center';
    const VERTICAL_JUSTIFY = 'justify';

    /**
     * @var bool 是否所有的数字展示都转换文本展示
     */
    private $_numberToText = true;
    /**
     * @var string 工作表保存名称
     */
    private $_title;
    /**
     * @var Spreadsheet 操作工作表
     */
    private $_spreadSheet;
    /**
     * @var int 当前工作表表索引
     */
    private $_activeSheetIndex = 0;
    /**
     * @var array 记录sheet的当前信息
     */
    private $_sheetInfo = [
        ['colNum' => 0, 'rowNum' => 1]
    ];
    /**
     * @var array sheet索引和key-map
     */
    private $_sheetIndexKey = [];
    /**
     * @var array 列的前缀字符表示结合
     */
    private $_colSigns = [];
    /**
     * @var array 当前表头
     */
    protected $headers = [];

    /**
     * 设置是否所有数字展示都转换文本
     *
     * @param bool $value
     * @return $this
     */
    public function setNumberToText(bool $value)
    {
        $this->_numberToText = $value;
        return $this;
    }

    /**
     * 获取是否所有数字展示都转换文本
     *
     * @return bool
     */
    public function getNumberToText()
    {
        return $this->_numberToText;
    }

    /**
     * 设置工作表名称
     *
     * @param string|null $title
     * @return $this
     */
    public function setTitle(?string $title = null)
    {
        $this->_title = $title;
        return $this;
    }

    /**
     * 获取工作表名称
     *
     * @return string
     */
    public function getTitle(): string
    {
        if (null === $this->_title) {
            $this->_title = Util::uniqid();
        }
        return $this->_title;
    }

    /**
     * 获取当前行索引
     *
     * @return int
     */
    protected function getRowNum()
    {
        return $this->_sheetInfo[$this->_activeSheetIndex]['rowNum'];
    }

    /**
     * 获取当前的列表
     *
     * @return int
     */
    protected function getColNum()
    {
        return $this->_sheetInfo[$this->_activeSheetIndex]['colNum'];
    }

    /**
     * 列标后移
     *
     * @param int|null $num
     * @return $this
     */
    public function nextCol(?int $num = 1)
    {
        $this->_sheetInfo[$this->_activeSheetIndex]['colNum'] += $num;
        return $this;
    }

    /**
     * 行标后移
     *
     * @param int|null $num
     * @return $this
     */
    public function nextRow(?int $num = 1)
    {
        $this->_sheetInfo[$this->_activeSheetIndex]['rowNum'] += $num;
        $this->_sheetInfo[$this->_activeSheetIndex]['colNum'] = 0;
        return $this;
    }

    /**
     * 获取 col 的字母表示
     *
     * @param int|null $colNum
     * @return mixed
     */
    public function getColSign(?int $colNum = null)
    {
        $colNum = $colNum ?: $this->_sheetInfo[$this->_activeSheetIndex]['colNum'];
        if (!isset($this->_colSigns[$colNum])) {
            // 计算列的字母表示
            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $len   = strlen($chars);
            $index = (int)fmod($colNum, $len);
            $mod   = (int)floor($colNum / $len);
            if (0 == $mod) {
                $colSign = $chars{$index};
            } else {
                $colSign = "{$chars{$mod - 1}}{$chars{$index}}";
            }
            $this->_colSigns[$colNum] = $colSign;
        }
        return $this->_colSigns[$colNum];
    }

    /**
     * 获取单元格的表示代码
     *
     * @param int|null $colNum
     * @param int|null $rowNum
     * @return string
     */
    public function getCellSign(?int $colNum = null, ?int $rowNum = null)
    {
        $colNum = $colNum ?: $this->_sheetInfo[$this->_activeSheetIndex]['colNum'];
        $rowNum = $rowNum ?: $this->_sheetInfo[$this->_activeSheetIndex]['rowNum'];
        return "{$this->getColSign($colNum)}{$rowNum}";
    }

    /**
     * 获取操作工作表
     *
     * @return Spreadsheet
     * @throws Exception
     */
    protected function getSpreadSheet()
    {
        if (null === $this->_spreadSheet) {
            $this->_spreadSheet = new Spreadsheet();
        }
        return $this->_spreadSheet;
    }

    private $_defaultUsed = false;

    /**
     * 增加sheet
     *
     * @param string|null $title
     * @param bool $noDefault 是否保留默认worksheet
     * @param string|null $key
     * @return $this
     * @throws Exception
     */
    public function addSheet(?string $title = null, bool $noDefault = false, ?string $key = null)
    {
        if (0 === $this->_activeSheetIndex && !$this->_defaultUsed && !$noDefault) {
            $this->_defaultUsed = true;
            $newIndex           = $this->_activeSheetIndex;
            $title              = empty($title) ? ("Sheet" . $newIndex) : $title;
            // 设置sheet名称
            $this->setSheetTitle($title);
        } else {
            $newIndex = $this->_activeSheetIndex + 1;
            $title    = empty($title) ? ("Sheet" . $newIndex) : $title;
            // 设置sheet名称
            $this->getSpreadSheet()
                ->addSheet(new Worksheet($this->getSpreadSheet(), $title), $newIndex);
            // 设置索引sheet信息
            $this->_sheetInfo[$newIndex] = ['colNum' => 0, 'rowNum' => 1];
        }
        // 设置激活sheet
        $this->getSpreadSheet()->setActiveSheetIndex($newIndex);
        // 设置激活sheet索引信息
        $this->_activeSheetIndex = $newIndex;
        if (null !== $key) {
            $this->_sheetIndexKey[$key] = $newIndex;
        }
        return $this;
    }

    /**
     * 获取当前操作工作表
     *
     * @return Worksheet
     * @throws Exception
     */
    public function getActiveSheet()
    {
        return $this->getSpreadSheet()->getActiveSheet();
    }

    /**
     * 设置当前操作表的名称
     *
     * @param string|null $title
     * @return $this
     * @throws Exception
     */
    public function setSheetTitle(?string $title = null)
    {
        $title = $title ?: "Sheet" . $this->_activeSheetIndex;
        $this->getActiveSheet()->setTitle($title);
        return $this;
    }

    /**
     * 设置操作工作表的索引
     *
     * @param string|int $key
     * @return $this
     * @throws Exception
     */
    public function setActiveSheetIndex($key)
    {
        $index = $this->_sheetIndexKey[$key] ?? $key;
        if (!is_int($index)) {
            throw new Exception("未创建的工作表索引{$key}");
        }
        $this->getSpreadSheet()->setActiveSheetIndex($index);
        $this->_activeSheetIndex = $index;
        return $this;
    }

    /**
     * 填写单元格
     *
     * @param string $cellSign
     * @param mixed $value
     * @return $this
     * @throws Exception
     */
    public function setCellValue(string $cellSign, $value)
    {
        $activeSheet = $this->getActiveSheet();
        if ($this->getNumberToText() && preg_match('#^-?\d+(\.\d+)?$#', $value)) {
            $activeSheet->setCellValueExplicit($cellSign, $value, DataType::TYPE_STRING2);
        } else if (preg_match('#^-?\d*\.\d*0$#', $value)) {
            // \d+.\d*0 格式的浮点数，只能用文本方式展示
            $activeSheet->setCellValueExplicit($cellSign, $value, DataType::TYPE_STRING2);
        } else if (preg_match('#^\d{12,}$#', $value)) {
            // 12位以上科学计数法展示，16位数字以上显示都是0，所以全部设置为文本
            $activeSheet->setCellValueExplicit($cellSign, $value, DataType::TYPE_STRING2);
        } else {
            $activeSheet->setCellValue($cellSign, $value);
        }
        return $this;
    }

    /**
     * 书写一行数据
     *
     * @param array $data
     * @return $this
     * @throws Exception
     */
    public function writeLine(array $data)
    {
        if (!empty($this->headers)) {
            foreach ($this->headers as $field => $label) {
                $this->setCellValue($this->getCellSign(), isset($data[$field]) ? $data[$field] : '');
                $this->nextCol();
            }
        } else {
            foreach ($data as $val) {
                $this->setCellValue($this->getCellSign(), $val);
                $this->nextCol();
            }
        }
        $this->nextRow();
        return $this;
    }

    /**
     * 批量书写数据
     *
     * @param array $res
     * @return $this
     * @throws Exception
     */
    public function writeData(array $res = [])
    {
        foreach ($res as $re) {
            $this->writeLine($re);
        }
        return $this;
    }

    /**
     * 设置表头字段
     *
     * @param array|null $headers
     * @param bool $writeExcel
     * @return $this
     * @throws Exception
     */
    public function setHeaders(?array $headers = null, bool $writeExcel = true)
    {
        if ($writeExcel) {
            $this->headers = [];
            $this->writeLine($headers);
        }
        $this->headers = $headers;
        return $this;
    }

    /**
     * 获取表头字段
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * 装填数据，支持单元格合并，同html-table一样，使用 colspan 和 rowspan 表示单元格合并的数量和方向
     *
     * @param array $records
     * @param bool $setHeader 是否将字段作为数据表的表头
     * @return $this
     * @throws Exception
     */
    public function writeMergeData(array $records, bool $setHeader = false)
    {
        $activeSheet  = $this->getActiveSheet();
        $fields       = [];
        $placeholders = [];
        foreach ($records as $idx => $record) {
            foreach ($record as $field => $value) {
                if (is_array($value)) {
                    $colspan         = $value['colspan'] ?? 1;
                    $rowspan         = $value['rowspan'] ?? 1;
                    $cellValue       = $value['value'] ?? '';
                    $horizontalStyle = $value['horizontal'] ?? '';
                    $verticalStyle   = $value['vertical'] ?? '';
                } else {
                    $colspan         = 1;
                    $rowspan         = 1;
                    $cellValue       = $value;
                    $horizontalStyle = '';
                    $verticalStyle   = '';
                }
                if (is_string($field)) {
                    $fields[$field] = $cellValue;
                }
                // 设置过占位符，列标需要按照占位符向后移动位数
                while (isset($placeholders[$idx][$this->getColNum()])) {
                    $this->nextCol();
                }
                $startCellSign = $this->getCellSign();
                $this->setCellValue($startCellSign, $cellValue);
                // 书写单元格
                if ($colspan > 1 && $rowspan > 1) {
                    // 对齐样式
                    $horizontalStyle = $horizontalStyle ?: 'center';
                    $verticalStyle   = $verticalStyle ?: 'center';
                    // 列、行合并
                    $curColNum   = $this->getColNum();
                    $curRowNum   = $this->getRowNum();
                    $endCellSign = $this->getCellSign($curColNum + $colspan - 1, $curRowNum + $rowspan - 1);
                    $activeSheet->mergeCells("{$startCellSign}:{$endCellSign}");
                    $this->fillColPlaceholder($placeholders, $idx, $curColNum + 1, $colspan - 1, true);
                    $_idx = $idx + 1;
                    while (--$rowspan) {
                        $this->fillColPlaceholder($placeholders, $_idx++, $curColNum, $colspan, false);
                    }
                } else if ($colspan > 1) {
                    // 对齐样式
                    $horizontalStyle = $horizontalStyle ?: 'center';
                    // 列合并
                    $curColNum   = $this->getColNum();
                    $curRowNum   = $this->getRowNum();
                    $endCellSign = $this->getCellSign($curColNum + $colspan - 1, $curRowNum);
                    $activeSheet->mergeCells("{$startCellSign}:{$endCellSign}");
                    $this->fillColPlaceholder($placeholders, $idx, $curColNum + 1, $colspan - 1, true);
                } else if ($rowspan > 1) {
                    // 对齐样式
                    $verticalStyle = $verticalStyle ?: 'center';
                    // 行合并
                    $curColNum   = $this->getColNum();
                    $curRowNum   = $this->getRowNum();
                    $endCellSign = $this->getCellSign($curColNum, $curRowNum + $rowspan - 1);
                    $activeSheet->mergeCells("{$startCellSign}:{$endCellSign}");
                    $this->fillRowPlaceholder($placeholders, $idx + 1, $curColNum, $rowspan);
                }
                // 设置样式
                if ($horizontalStyle) {
                    $this->setAlignStyle($startCellSign, self::ALIGN_TYPE_HORIZONTAL, $horizontalStyle);
                }
                if ($verticalStyle) {
                    $this->setAlignStyle($startCellSign, self::ALIGN_TYPE_VERTICAL, $verticalStyle);
                }
                // 列坐标右移
                $this->nextCol();
            }
            // 行坐标下移
            $this->nextRow();
        }
        if ($setHeader) {
            $this->setHeaders($fields, false);
        }
        return $this;
    }

    /**
     * 获取单元格样式类
     *
     * @param string $cell
     * @return \PhpOffice\PhpSpreadsheet\Style\Style
     * @throws Exception
     */
    protected function getStyle(string $cell)
    {
        return $this->getActiveSheet()->getStyle($cell);
    }

    /**
     * 设置单元格对齐方式
     *
     * @param string $cell
     * @param string|null $type
     * @param string|null $style
     * @throws Exception
     */
    public function setAlignStyle(string $cell, ?string $type = self::ALIGN_TYPE_HORIZONTAL, ?string $style = null)
    {
        $alignment = $this->getStyle($cell)->getAlignment();
        if ($type === self::ALIGN_TYPE_HORIZONTAL) {
            $alignment->setHorizontal($style);
        } else {
            $alignment->setVertical($style);
        }
    }

    /**
     * 列标占位
     *
     * @param array $placeholders
     * @param int $idx
     * @param int $rowNum
     * @param int $colspan
     * @param bool $moveCol
     */
    protected function fillColPlaceholder(array &$placeholders, int $idx, int $rowNum, int $colspan, bool $moveCol = false)
    {
        while ($colspan > 0) {
            $placeholders[$idx][$rowNum++] = 1;
            $colspan--;
            if ($moveCol) {
                $this->nextCol();
            }
        }
    }

    /**
     * 行标占位
     *
     * @param array $placeholders
     * @param int $idx
     * @param int $rowNum
     * @param int $rowspan
     */
    protected function fillRowPlaceholder(array &$placeholders, int $idx, int $rowNum, int $rowspan)
    {
        while ($rowspan > 1) {
            $placeholders[$idx++][$rowNum] = 1;
            $rowspan--;
        }
    }

    /**
     * 文件excel下载
     *
     * @throws Exception
     * @throws WriterException
     */
    public function download()
    {
        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename={$this->getTitle()}.xlsx");
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($this->getSpreadSheet(), 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    /**
     * 持久化 excel 到服务器文件上
     *
     * @param string $filePath
     * @throws Exception
     * @throws WriterException
     */
    public function save(string $filePath)
    {
        (new Writer($this->getSpreadSheet()))->save($filePath);
    }

    /**
     * 读取 excel 文件
     *
     * @param string $filePath
     * @param int|null $idx
     * @return array
     * @throws Exception
     */
    public static function readFile(string $filePath, ?int $idx = 0): array
    {
        $reader      = new Reader();
        $spreadsheet = $reader->load($filePath);
        if (null !== $idx) {
            $spreadsheet->setActiveSheetIndex($idx);
            return $spreadsheet->getActiveSheet()->toArray();
        }
        $count = $spreadsheet->getSheetCount();
        $data  = [];
        for ($i = 0; $i < $count; $i++) {
            $spreadsheet->setActiveSheetIndex($i);
            $data[] = $spreadsheet->getActiveSheet()->toArray();
        }
        return $data;
    }
}
