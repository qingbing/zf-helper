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
     * 将浮点数保留 $precision 位小数
     * @param float $val
     * @param int $precision
     * @return string
     */
    public static function round(float $val, $precision = 2)
    {
        return sprintf("%.{$precision}f", $val);
    }

    /**
     * 将浮点数转换成百分数表示
     *
     * @param float $val
     * @param int $precision
     * @return string
     */
    public static function percent(float $val, $precision = 2)
    {
        return self::round($val * 100, $precision) . '%';
    }

    /**
     * 用户名 隐秘显示
     * @param string $username
     * @return string
     */
    public static function maskUsername(string $username)
    {
        $len       = mb_strlen($username);
        $repeatLen = ceil($len / 2);
        $repeat    = str_repeat('*', $len - $repeatLen);
        return mb_substr($username, 0, $repeatLen) . $repeat;
    }

    /**
     * 姓名 隐秘显示
     * @param string $username
     * @return string
     */
    public static function maskName(string $username)
    {
        $repeat = str_repeat('*', mb_strlen($username) - 1);
        return mb_substr($username, 0, 1) . $repeat;
    }

    /**
     * 隐秘身份证中的年月日
     * @param string $identity
     * @return mixed
     */
    public static function maskIdentity(string $identity)
    {
        if (strlen($identity) == 18) {
            return substr_replace($identity, '********', 6, 8);
        }
        return substr_replace($identity, '********', 4, 8);
    }

    /**
     * 手机号 隐秘显示
     *
     * @param string $phone
     * @param int $type 安全类型
     * @return mixed|string
     */
    public static function maskPhone(string $phone, $type = 0)
    {
        if ($type == 1) { //仅仅显示后面四位
            return '****' . substr($phone, -4);
        }
        if ($type == 2) {
            return '尾号' . substr($phone, -4);
        }
        //屏蔽中间四位
        return substr_replace($phone, '****', 3, 4);
    }

    /**
     * 银行卡 隐秘显示
     *
     * @param string $cardNum
     * @param int $type
     * @return mixed
     */
    public static function maskBankCard(string $cardNum, int $type = 0)
    {
        if (1 === $type) {
            $len = strlen($cardNum);
            return substr_replace($cardNum, str_repeat('*', $len - 8), 4, -4);
        }
        return substr_replace($cardNum, ' **** **** ', 4, -4);
    }
}