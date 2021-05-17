<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper;

/**
 * 数学函数
 *
 * Class Math
 * @package Zf\Helper
 */
class Math
{
    /**
     * 浮点数小数点格式化
     *
     * @param mixed $val
     * @param int $precision
     * @return string
     */
    public static function round($val, int $precision = 2)
    {
        return sprintf("%.{$precision}f", $val);
    }

    /**
     * 除法
     *
     * @param float $piece
     * @param float $total
     * @param int|null $precision
     * @return float|int|string
     */
    public static function division($piece, $total, ?int $precision = null)
    {
        if (0 == $total || 0 == $piece) {
            $val = 0;
        } else {
            $val = $piece / $total;
        }
        if (null !== $precision) {
            $val = self::round($val);
        }
        return $val;
    }
}