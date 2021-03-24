<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper;

use DateTime;
use DateTimeZone;
use Exception;

/**
 * 常用格式化
 *
 * Class Format
 * @package Zf\Helper
 */
class Format
{
    /**
     * 返回数组的值
     *
     * @param string $key
     * @param array $data
     * @return mixed
     */
    public static function dataValue(string $key, $data = [])
    {
        if (isset($data[$key])) {
            return $data[$key];
        }
        return $key;
    }

    /**
     * 标准格式化日期
     *
     * @param null | int $time
     * @param bool $todayIfNull
     * @param string $format
     * @return false|null|string
     */
    public static function date($time = null, $todayIfNull = true, $format = 'Y-m-d')
    {
        if (empty($time)) {
            return $todayIfNull ? date($format) : null;
        } else {
            return date($format, $time);
        }
    }

    /**
     * 标准格式化日期
     *
     * @param null | int $time
     * @param bool $nowIfNull
     * @param string $format
     * @return false|null|string
     */
    public static function datetime($time = null, $nowIfNull = true, $format = 'Y-m-d H:i:s')
    {
        if (null === $time) {
            return $nowIfNull ? date($format) : null;
        } else {
            return date($format, $time);
        }
    }

    /**
     * 时区对象
     *
     * @var DateTimeZone
     */
    private static $timezone;

    /**
     * 获取当前纳米级时间表示
     *
     * @return string
     * @throws Exception
     */
    public static function microDatetime()
    {
        // 确保时区是设置的
        if (!self::$timezone) {
            self::$timezone = new DateTimeZone(date_default_timezone_get() ?: 'PRC');
        }
        // php7.1+ 始终开启的纳秒
        if (PHP_VERSION_ID < 70100) {
            $ts = DateTime::createFromFormat('U.u', sprintf('%.6F', microtime(true)), self::$timezone);
        } else {
            $ts = new DateTime(null, self::$timezone);
        }
        $ts->setTimezone(self::$timezone);
        return $ts->format('Y-m-d H:i:s.u');
    }
}