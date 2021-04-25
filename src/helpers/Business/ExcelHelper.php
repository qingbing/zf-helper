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
     * @var int 当前操作列
     */
    private $_colNum = 0;
    /**
     * @var int 当前操作行
     */
    private $_rowNum = 1;
    /**
     * @var array 列的前缀字符表示结合
     */
    private $_colSigns = [];
    /**
     * @var array 当前表头
     */
    protected $headers = [];

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
            $this->_spreadSheet->setActiveSheetIndex($this->_activeSheetIndex);
        }
        return $this->_spreadSheet;
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
     * 设置操作工作表的索引
     *
     * @param int $activeSheetIndex
     * @return $this
     * @throws Exception
     */
    public function setActiveSheetIndex(int $activeSheetIndex)
    {
        if (null !== $this->_spreadSheet) {
            $this->getSpreadSheet()->setActiveSheetIndex($activeSheetIndex);
        }
        $this->_activeSheetIndex = $activeSheetIndex;
        return $this;
    }

    /**
     * 获取当前操作的sheet
     *
     * @return int
     */
    public function getActiveSheetIndex(): int
    {
        return $this->_activeSheetIndex;
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
     * 设置当前操作表的名称
     *
     * @param string|null $title
     * @return $this
     * @throws Exception
     */
    public function setActiveSheetTitle(?string $title = null)
    {
        $title = $title ?: "sheet" . $this->getActiveSheetIndex();
        $this->getActiveSheet()->setTitle($title);
        return $this;
    }

    /**
     * 获取当前行索引
     *
     * @return int
     */
    public function getRowNum()
    {
        return $this->_rowNum;
    }

    /**
     * 获取当前的列表
     *
     * @return int
     */
    protected function getColNum()
    {
        return $this->_colNum;
    }

    /**
     * 列标后移
     *
     * @param int|null $num
     * @return $this
     */
    public function nextCol(?int $num = 1)
    {
        $this->_colNum += $num;
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
        $this->_rowNum += $num;
        $this->_colNum = 0;
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
        null === $colNum && ($colNum = $this->_colNum);
        if (!isset($this->_colSigns[$colNum])) {
            $this->_colSigns[$colNum] = $this->computeColSign($colNum);
        }
        return $this->_colSigns[$colNum];
    }

    /**
     * 计算列标记
     *
     * @param $colNum
     * @return mixed
     */
    protected function computeColSign($colNum)
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $len   = strlen($chars);
        $index = (int)fmod($colNum, $len);
        $mod   = (int)floor($colNum / $len);
        if (0 == $mod) {
            $colSign = $chars{$index};
        } else {
            $colSign = "{$chars{$mod}}{$chars{$index}}";
        }
        return $colSign;
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
        $rowNum = (null === $rowNum) ? $this->getRowNum() : $rowNum;
        return "{$this->getColSign($colNum)}{$rowNum}";
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
        if (preg_match('#^\d*\.\d*0$#', $value)) {
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
                    $colspan   = $value['colspan'] ?? 1;
                    $rowspan   = $value['rowspan'] ?? 1;
                    $cellValue = $value['value'] ?? '';
                } else {
                    $colspan   = 1;
                    $rowspan   = 1;
                    $cellValue = $value;
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
                    // 列合并
                    $curColNum   = $this->getColNum();
                    $curRowNum   = $this->getRowNum();
                    $endCellSign = $this->getCellSign($curColNum + $colspan - 1, $curRowNum);
                    $activeSheet->mergeCells("{$startCellSign}:{$endCellSign}");
                    $this->fillColPlaceholder($placeholders, $idx, $curColNum + 1, $colspan - 1, true);
                } else if ($rowspan > 1) {
                    // 行合并
                    $curColNum   = $this->getColNum();
                    $curRowNum   = $this->getRowNum();
                    $endCellSign = $this->getCellSign($curColNum, $curRowNum + $rowspan - 1);
                    $activeSheet->mergeCells("{$startCellSign}:{$endCellSign}");
                    $this->fillRowPlaceholder($placeholders, $idx + 1, $curColNum, $rowspan);
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