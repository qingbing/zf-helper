<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper;

/**
 * 数据进制转换
 *
 * Class AsciiHelper
 * @package Zf\Helper
 */
class AsciiHelper
{
    /**
     * 将字符串转换成十六进制
     *
     * @param string $var
     * @return string
     */
    public static function str2Binary(string $var): string
    {
        $R   = [];
        $len = strlen($var);
        for ($i = 0; $i < $len; $i++) {
            array_push($R, self::chr2Binary($var{$i}));
        }
        return implode('', $R);
    }

    /**
     * 将字符串转换成十六进制
     *
     * @param string $var
     * @return string
     */
    public static function str2Hex(string $var): string
    {
        $R   = [];
        $len = strlen($var);
        for ($i = 0; $i < $len; $i++) {
            array_push($R, self::chr2Hex($var{$i}));
        }
        return implode('', $R);
    }

    /**
     * 二进制转换成字符串
     *
     * @param string $binary
     * @return bool|string
     */
    public static function binary2Str($binary)
    {
        $len = strlen($binary);
        if ($len % 8 != 0) {
            return false;
        }
        if (0 == $len) {
            return "";
        }
        $R        = "";
        $startPos = 0;
        while (true) {
            $chr      = substr($binary, $startPos, 8);
            $R        .= chr(bindec($chr));
            $startPos += 8;
            if ($startPos >= $len) {
                break;
            }
        }
        return $R;
    }

    /**
     * 十六进制转换成字符串
     *
     * @param string $hex
     * @return bool|string
     */
    public static function hex2Str($hex)
    {
        $len = strlen($hex);
        if (0 == $len) {
            return "";
        }
        if ($len % 2 != 0) {
            return false;
        }
        $R        = "";
        $startPos = 0;
        while (true) {
            $chr      = substr($hex, $startPos, 2);
            $R        .= chr(hexdec($chr));
            $startPos += 2;
            if ($startPos >= $len) {
                break;
            }
        }
        return $R;
    }

    /**
     * 将字符或首字母转换成十进制
     *
     * @param string|int $chr
     * @return int
     */
    protected static function chr2Int($chr): int
    {
        if (!is_integer($chr)) {
            $chr = ord($chr);
        }
        return $chr;
    }

    /**
     * 将字符或首字母转换成十六进制
     *
     * @param string|int $chr
     * @return string
     */
    protected static function chr2Hex($chr): string
    {
        $num = self::chr2Int($chr);
        $R   = "00";
        $lib = "0123456789ABCDEF";
        $i   = 1;
        while ($num > 0) {
            $R{$i} = $lib{$num & 15};
            $num   = $num >> 4;
            $i--;
        }
        return $R;
    }

    /**
     * 将字符或首字母转换成二进制
     *
     * @param mixed $chr
     * @return string
     */
    protected static function chr2Binary($chr): string
    {
        $num = self::chr2Int($chr);
        $R   = "00000000";
        $i   = 7;
        while ($num > 0) {
            $R{$i} = $num & 1;
            $num   = $num >> 1;
            $i--;
        }
        return $R;
    }
}