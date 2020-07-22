<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper;

use Zf\Helper\Exceptions\Exception;

/**
 * 记时器
 *
 * Class Timer
 * @package Zf\Helper
 */
class Timer
{
    /**
     * 时间记录栈
     *
     * @var array
     */
    static private $_timeStore = [];

    /**
     * 开启一个 TIMER
     *
     * @param string $type
     * @return mixed|string
     */
    public static function begin($type = 'app')
    {
        if (isset(self::$_timeStore[$type])) {
            return self::$_timeStore[$type];
        }
        return self::$_timeStore[$type] = self::microTime(false);
    }

    /**
     * 获取一个 TIMER 存活的时间
     * @param string $type
     * @return string
     *
     * @throws Exception
     */
    public static function end($type = 'app')
    {
        if (!isset(self::$_timeStore[$type])) {
            throw new Exception(interpolate('没有"{type}"对应的 timer', [
                'type' => $type,
            ]), 1010006001);
        }
        $e = self::microTime(false);
        $s = self::$_timeStore[$type];
        unset(self::$_timeStore[$type]);
        return sprintf('%.6f', $e - $s);
    }

    /**
     * 获取当前的浮点型时间
     * @param bool $isFormat
     * @return string
     */
    public static function microTime($isFormat = true)
    {
        if ($isFormat) {
            list($microSec, $sec) = explode(" ", microtime());
            return Format::datetime($sec) . ' ' . substr($microSec, 2, 6);
        } else {
            return microtime(true);
        }
    }
}