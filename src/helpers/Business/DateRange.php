<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Business;

use Carbon\Carbon;
use Exception;
use Zf\Helper\Abstracts\Factory;
use Zf\Helper\Exceptions\ParameterException;
use Zf\Helper\Exceptions\BusinessException;

/**
 * 时间段获取
 *
 * Class DateRange
 * @package Zf\Helper\Business
 */
class DateRange extends Factory
{
    const RANGE_TYPE_DAY     = "day";
    const RANGE_TYPE_WEEK    = "week";
    const RANGE_TYPE_MONTH   = "month";
    const RANGE_TYPE_QUARTER = "quarter";
    const RANGE_TYPE_YEAR    = "year";

    /**
     * 所有周期类型
     *
     * @return array
     */
    public static function types()
    {
        return [
            self::RANGE_TYPE_DAY     => "天",
            self::RANGE_TYPE_WEEK    => "周",
            self::RANGE_TYPE_MONTH   => "月",
            self::RANGE_TYPE_QUARTER => "季",
            self::RANGE_TYPE_YEAR    => "年",
        ];
    }

    const DATA_TYPE_DATE     = "date";
    const DATA_TYPE_DATETIME = "datetime";

    /**
     * 所有返回时间类型
     *
     * @return array
     */
    public static function dataTypes()
    {
        return [
            self::DATA_TYPE_DATE     => "日期",
            self::DATA_TYPE_DATETIME => "时间",
        ];
    }

    /**
     * @var string 返回时间类型
     */
    private $_rangeType = self::RANGE_TYPE_DAY;
    /**
     * @var string 时间类型
     */
    private $_dataType;
    /**
     * @var string 时间格式 Y-m-d
     */
    private $_dateFormat = "Y-m-d";
    /**
     * @var string 时间格式 Y-m-d
     */
    private $_dateDelimiter = "-";
    /**
     * @var int 周开始的第一天，0为周日
     */
    private $_weekStart = 1;
    /**
     * @var Carbon 开始时间
     */
    private $_start;
    /**
     * @var Carbon 结束时间
     */
    private $_end;
    /**
     * @var string 开始时间的时间格式
     */
    private $_startFormat;
    /**
     * @var string 结束时间的时间格式
     */
    private $_endFormat;

    /**
     * 设置单位类型
     *
     * @param string $rangeType
     * @return $this
     * @throws ParameterException
     */
    public function setRangeType(string $rangeType)
    {
        if (!in_array($rangeType, array_keys(self::types()))) {
            throw new ParameterException("不支持的单位类型'{$rangeType}'", 1010008001);
        }
        $this->_rangeType = $rangeType;
        return $this;
    }

    /**
     * 返回时间类型
     *
     * @return string
     */
    public function getDataType()
    {
        if (null === $this->_dataType) {
            return self::DATA_TYPE_DATE;
        }
        return $this->_dataType;
    }

    /**
     * 设置时间类型
     *
     * @param string $dataType
     * @return $this
     * @throws ParameterException
     */
    public function setDataType(string $dataType)
    {
        if (null !== $this->_dataType) {
            throw new ParameterException("时间类型已经设置", 1010008002);
        }
        $this->_dataType = $dataType;
        return $this;
    }

    /**
     * 设置日期分隔符号，同时会定义好
     * @param string $dateDelimiter
     * @return $this
     */
    public function setDateDelimiter(string $dateDelimiter)
    {
        $this->_dateDelimiter = $dateDelimiter;
        $this->_dateFormat    = implode($dateDelimiter, ["Y", "m", "d"]);
        return $this;
    }

    /**
     * 设置周开始的星期索引
     *
     * @param int $weekStart
     * @return $this
     */
    public function setWeekStart(int $weekStart)
    {
        $this->_weekStart = $weekStart;
        return $this;
    }

    /**
     * 设置开始时间
     *
     * @param mixed $start
     * @return $this
     * @throws Exception
     */
    public function setStart($start)
    {
        $this->_start = (new Carbon($start))
            ->setMinute(0)
            ->setHour(0)
            ->setSecond(0);
        return $this;
    }

    /**
     * 设置结束时间
     *
     * @param mixed $end
     * @return $this
     * @throws Exception
     */
    public function setEnd($end)
    {
        $this->_end = new Carbon($end);
        return $this;
    }

    /**
     * 获取最终的日期范围
     *
     * @return array
     * @throws Exception
     */
    public function getRange()
    {
        if (empty($this->_start) || empty($this->_end)) {
            throw new BusinessException("必须设置开始时间和结束时间", 1010008003);
        }
        if ($this->_start->isAfter($this->_end)) {
            throw new BusinessException("开始时间必须大于结束时间", 1010008004);
        }
        if (self::DATA_TYPE_DATETIME === $this->_dataType) {
            $this->_startFormat = $this->_dateFormat . " 00:00:00";
            $this->_endFormat   = $this->_dateFormat . " 23:59:59";
        } else {
            $this->_startFormat = $this->_dateFormat;
            $this->_endFormat   = $this->_dateFormat;
        }
        switch ($this->_rangeType) {
            case "week":
                return $this->weekRange();
            case "month":
                return $this->monthRange();
            case "quarter":
                return $this->quarterRange();
            case "year":
                return $this->yearRange();
            default:
                return $this->dayRange();
        }
    }

    /**
     * 获取天的开始和结束时间
     *
     * @return array
     */
    protected function dayRange()
    {
        $R      = [];
        $carbon = $this->_start;
        while (true) {
            if ($carbon->isAfter($this->_end)) {
                break;
            }
            if (self::DATA_TYPE_DATE === $this->_dataType) {
                $start = $end = $label = $range = $this->format($carbon, true);
            } else {
                $start = $this->format($carbon, true);
                $end   = $this->format($carbon, false);
                $label = $range = $this->formatDate($carbon);
            }
            array_push($R, [
                "start" => $start,
                "end"   => $end,
                "label" => $label,
                "range" => $range,
            ]);
            $carbon->addDay();
        }
        return $R;
    }

    /**
     * 获取最终周的开始和结束时间
     *
     * @return array
     */
    protected function weekRange()
    {
        $carbon = $this->_start;
        $carbon->subDays($carbon->weekday() - $this->_weekStart);
        $R = [];
        while (true) {
            if ($carbon->isAfter($this->_end)) {
                break;
            }
            $start = $this->format($carbon, true);
            $range = $this->formatDate($carbon);

            $carbon->addDays(6);
            $end   = $this->format($carbon, false);
            $range .= " ~ " . $this->formatDate($carbon);

            $label = $carbon->format("Y-\WW");
            array_push($R, [
                "start" => $start,
                "end"   => $end,
                "label" => $label,
                "range" => $range,
            ]);
            $carbon->addDay();
        }
        return $R;
    }

    /**
     * 获取最终月的开始和结束时间
     *
     * @return array
     */
    protected function monthRange()
    {
        $carbon = $this->_start;
        $R      = [];
        while (true) {
            $carbon->setDay(1);
            if ($carbon->isAfter($this->_end)) {
                break;
            }
            $start = $this->format($carbon, true);
            $range = $this->formatDate($carbon);

            $carbon->addMonth()->subDay();
            $end   = $this->format($carbon, false);
            $range .= " ~ " . $this->formatDate($carbon);

            $label = $carbon->format("Y-m");
            array_push($R, [
                "start" => $start,
                "end"   => $end,
                "label" => $label,
                "range" => $range,
            ]);
            $carbon->addDay();
        }
        return $R;
    }

    /**
     * 获取最终季度的开始和结束时间
     *
     * @return array
     */
    protected function quarterRange()
    {
        $carbon = $this->_start;
        $carbon = $carbon->setMonth(($carbon->quarter - 1) * 3 + 1);
        $R      = [];
        while (true) {
            $carbon->setDay(1);
            if ($carbon->isAfter($this->_end)) {
                break;
            }
            $start = $this->format($carbon, true);
            $range = $this->formatDate($carbon);

            $carbon->addQuarter()->subDay();
            $end   = $this->format($carbon, false);
            $range .= " ~ " . $this->formatDate($carbon);

            $label = $carbon->format("Y-Q") . $carbon->quarter;
            array_push($R, [
                "start" => $start,
                "end"   => $end,
                "label" => $label,
                "range" => $range,
            ]);
            $carbon->addDay();
        }
        return $R;
    }

    /**
     * 获取最终年份的开始和结束时间
     *
     * @return array
     */
    protected function yearRange()
    {
        $carbon = $this->_start;
        $carbon = $carbon->setMonth(1);
        $R      = [];
        while (true) {
            $carbon->setDay(1);
            if ($carbon->isAfter($this->_end)) {
                break;
            }
            $start = $this->format($carbon, true);
            $range = $this->formatDate($carbon);

            $carbon->addYear()->subDay();
            $end   = $this->format($carbon, false);
            $range .= " ~ " . $this->formatDate($carbon);

            $label = $carbon->format("Y");
            array_push($R, [
                "start" => $start,
                "end"   => $end,
                "label" => $label,
                "range" => $range,
            ]);
            $carbon->addDay();
        }
        return $R;
    }

    /**
     * 返回时间格式化
     *
     * @param Carbon $carbon
     * @param bool $isStart
     * @return string
     */
    protected function format(Carbon $carbon, bool $isStart)
    {
        return $isStart ? $carbon->format($this->_startFormat) : $carbon->format($this->_endFormat);
    }

    /**
     * 返回日期格式
     *
     * @param Carbon $carbon
     * @return string
     */
    protected function formatDate(Carbon $carbon)
    {
        return $carbon->format($this->_dateFormat);
    }
}