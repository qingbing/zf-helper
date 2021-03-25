<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Plugins\Crypt;

/**
 * base64对数据加密
 *
 * Class Base64
 * @package Zf\Helper\Plugins\Crypt
 */
class Base64
{
    /**
     * base64 码的替换字符
     * @var array
     */
    private static $_pattern = [
        '0' => '00',
        '+' => '01',
        '/' => '02',
        '=' => '03',
    ];

    /**
     * base64 数据加密
     *
     * @param string $val
     * @return string
     */
    public static function encrypt(?string $val): string
    {
        return strtr(base64_encode($val), self::$_pattern);
    }

    /**
     * base64 数据解密
     *
     * @param string $val
     * @return string
     */
    public static function decrypt(?string $val): string
    {
        return base64_decode(strtr($val, array_flip(self::$_pattern)));
    }
}