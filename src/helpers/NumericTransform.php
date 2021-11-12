<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper;


use Zf\Helper\Exceptions\ParameterException;
use Zf\Helper\Exceptions\ProgramException;

/**
 * 辅助类 : 进制转化
 *
 * Class NumericTransform
 * @package Zf\Helper
 */
class NumericTransform
{
    /**
     * 任意进制数转化，不能大于 65
     *
     * @param int $n 需要转的10进制数
     * @param int $base 进制基数
     * @param int $length 是否前位补0的长度
     * @return string
     * @throws ProgramException
     */
    public static function decToBase(int $n, int $base, $length = 0)
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ+-_';
        $len   = strlen($chars);
        if ($base > $len) {
            throw new ProgramException("不能转换成大于{$len}以上的进制数");
        }
        $R = '';
        while (true) {
            $rest = intval(fmod($n, $base));
            $n    = floor(fdiv($n, $base));
            $R    = $chars{$rest} . $R;
            if ($n <= 0) {
                break;
            }
        }
        if ($length > 0) {
            return sprintf("%0{$length}s", $R);
        } else {
            return $R;
        }
    }

    /**
     * @var array 二进制和八进制转换关系
     */
    protected static $binaryOctal = [
        '000' => '0',
        '001' => '1',
        '010' => '2',
        '011' => '3',
        '100' => '4',
        '101' => '5',
        '110' => '6',
        '111' => '7',
    ];
    /**
     * @var array 二进制和十六进制转换关系
     */
    protected static $binaryHex = [
        '0000' => '0',
        '0001' => '1',
        '0010' => '2',
        '0011' => '3',
        '0100' => '4',
        '0101' => '5',
        '0110' => '6',
        '0111' => '7',
        '1000' => '8',
        '1001' => '9',
        '1010' => 'A',
        '1011' => 'B',
        '1100' => 'C',
        '1101' => 'D',
        '1110' => 'E',
        '1111' => 'F',
    ];

    /**
     * 二进制转换成八进制数
     *
     * @param string $n
     * @return string
     * @throws ParameterException
     */
    public static function binaryToOctal($n)
    {
        $len = strlen($n);
        $mod = fmod($len, 3);
        if ($mod > 0) {
            $len = $len + 3 - $mod;
        }
        $ta             = str_split(sprintf("%0{$len}s", $n), 3);
        $R              = '';
        $binaryOctalLib = self::$binaryOctal;
        while (count($ta) > 0) {
            $base = array_shift($ta);
            if (!isset($binaryOctalLib[$base])) {
                throw new ParameterException("传递的「{$n}」不是有效的二进制数");
            }
            $R .= $binaryOctalLib[$base];
        }
        return $R;
    }

    /**
     * 二进制转换成十进制数
     *
     * @param int $n
     * @return int
     */
    public static function binaryToDec($n): int
    {
        $ta   = str_split($n);
        $base = 1;
        $R    = 0;
        while (count($ta) > 0) {
            $v = array_pop($ta);
            if ($v > 0) {
                $R += $base;
            }
            $base *= 2;
        }
        return $R;
    }

    /**
     * 二进制转换成十六进制数
     *
     * @param string $n
     * @return string
     * @throws ParameterException
     */
    public static function binaryToHex($n)
    {
        $len = strlen($n);
        $mod = fmod($len, 4);
        if ($mod > 0) {
            $len = $len + 4 - $mod;
        }
        $ta           = str_split(sprintf("%0{$len}s", $n), 4);
        $R            = '';
        $binaryHexLib = self::$binaryHex;
        while (count($ta) > 0) {
            $base = array_shift($ta);
            if (!isset($binaryHexLib[$base])) {
                throw new ParameterException("传递的「{$n}」不是有效的二进制数");
            }
            $R .= $binaryHexLib[$base];
        }
        return $R;
    }

    /**
     * 八进制转换成二进制数
     *
     * @param string $n
     * @return string
     * @throws ParameterException
     */
    public static function octalToBinary($n)
    {
        $ta          = str_split($n);
        $octalBinary = array_flip(self::$binaryOctal);
        $R           = '';
        while (count($ta) > 0) {
            $base = array_shift($ta);
            if (!isset($octalBinary[$base])) {
                throw new ParameterException("传递的「{$n}」不是有效的八进制数");
            }
            $R .= $octalBinary[$base];
        }
        return ltrim($R, '0');
    }

    /**
     * 八进制转换成十进制数
     *
     * @param string $n
     * @return float|int
     */
    public static function octalToDec($n)
    {
        $ta   = str_split($n);
        $base = 1;
        $R    = 0;
        while (count($ta) > 0) {
            $v = array_pop($ta);
            if ($v > 0) {
                $R += $base * $v;
            }
            $base *= 8;
        }
        return $R;
    }

    /**
     * 八进制转换成十六进制数
     *
     * @param string $n
     * @return string
     * @throws ParameterException
     */
    public static function octalToHex($n)
    {
        return self::binaryToHex(self::octalToBinary($n));
    }

    /**
     * 十进制转换成二进制数
     *
     * @param string $n
     * @return string
     */
    public static function decToBinary($n)
    {
        $R = '';
        while ($n > 0) {
            $R = ($n & 1) . $R;
            $n = $n >> 1;
        }
        return $R;
    }

    /**
     * 十进制转换成八进制数
     *
     * @param string $n
     * @return string
     */
    public static function decToOctal($n)
    {
        $R = '';
        while ($n > 0) {
            $R = ($n & 7) . $R;
            $n = $n >> 3;
        }
        return $R;
    }

    /**
     * 十进制转换成十六进制数
     *
     * @param string $n
     * @return string
     */
    public static function decToHex($n)
    {
        $chars = "0123456789ABCDEF";
        $R     = '';
        while ($n > 0) {
            $base = ($n & 15);
            $R    = $chars{$base} . $R;
            $n    = $n >> 4;
        }
        return $R;
    }

    /**
     * 十六进制转换成二进制数
     *
     * @param string $n
     * @return string
     * @throws ParameterException
     */
    public static function hexToBinary($n)
    {
        $ta        = str_split($n);
        $R         = '';
        $hexBinary = array_flip(self::$binaryHex);
        while (count($ta) > 0) {
            $base = array_shift($ta);
            if (!isset($hexBinary[$base])) {
                throw new ParameterException("传递的「{$n}」不是有效的十六进制数");
            }
            $R .= $hexBinary[$base];
        }
        return ltrim($R, '0');
    }

    /**
     * 十六进制转换成八进制数
     *
     * @param string $n
     * @return string
     * @throws ParameterException
     */
    public static function hexToOctal($n)
    {
        return self::binaryToOctal(self::hexToBinary($n));
    }

    /**
     * 十六进制转换成十进制数
     *
     * @param string $n
     * @return float|int
     * @throws ParameterException
     */
    public static function hexToDec($n)
    {
        $ta    = str_split(strtoupper($n));
        $chars = "0123456789ABCDEF";
        $base  = 1;
        $R     = 0;
        while (count($ta) > 0) {
            $v   = array_pop($ta);
            $pos = strpos($chars, $v);
            if (false === $pos) {
                throw new ParameterException("传递的「{$n}」不是有效的十六进制数");
            }
            if ($pos > 0) {
                $R += $base * $pos;
            }
            $base *= 16;
        }
        return $R;
    }
}