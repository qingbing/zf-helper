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
     * 开启一个timer
     *
     * @param string $type
     * @param bool $refresh
     * @return mixed
     */
    public static function begin($type = 'app', $refresh = false)
    {
        if ($refresh || !isset(self::$_timeStore[$type])) {
            self::$_timeStore[$type] = self::microtime();
        }
        return self::$_timeStore[$type];
    }

    /**
     * 结束timer并获取一个timer存活的时间
     * @param string $type
     * @return string
     */
    public static function end($type = 'app')
    {
        if (!isset(self::$_timeStore[$type])) {
            return -1;
        }
        $e = self::microtime();
        $s = self::$_timeStore[$type];
        return sprintf('%.6f', $e - $s);
    }

    /**
     * 获取当前的浮点型时间
     *
     * @return mixed
     */
    public static function microtime()
    {
        return microtime(true);
    }
}