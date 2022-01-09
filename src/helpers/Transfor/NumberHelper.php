<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Transfor;

use Zf\Helper\Exceptions\ProgramException;

/**
 * 辅助类 : 数据进制转化
 *      该类型中的二进制强制为 2字节(8byte) 的整数倍
 *
 * Class NumberHelper
 * @package Zf\Helper\Transfor
 */
class NumberHelper
{
    /**
     * 数字进制类型
     */
    const TYPE_BINARY = 'binary';
    const TYPE_OCTAL  = 'octal';
    const TYPE_DEC    = 'dec';
    const TYPE_HEX    = 'hex';
    const TYPE_BASE64 = 'base64';

    const BASE_CHARS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ+-_';

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
        '1010' => 'a',
        '1011' => 'b',
        '1100' => 'c',
        '1101' => 'd',
        '1110' => 'e',
        '1111' => 'f',
    ];

    /**
     * 十进制数转化任意进制数，不能大于 65
     *
     * @param int $n 需要转的10进制数
     * @param int $base 进制基数
     * @param int $length 是否前位补0的长度
     * @return string
     * @throws ProgramException
     */
    public static function decToBase(int $n, int $base, $length = 0)
    {
        $chars = self::BASE_CHARS;
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
     * 二进制转换成八进制数
     *
     * @param string $code
     * @return string
     * @throws ProgramException
     */
    public static function binaryToOctal(string $code)
    {
        $len = strlen($code);
        $mod = fmod($len, 3);
        if ($mod > 0) {
            $len = $len + 3 - $mod;
        }
        $ta             = str_split(sprintf("%0{$len}s", $code), 3);
        $R              = '';
        $binaryOctalLib = self::$binaryOctal;
        while (count($ta) > 0) {
            $base = array_shift($ta);
            if (!isset($binaryOctalLib[$base])) {
                throw new ProgramException("传递的「{$code}」不是有效的二进制数");
            }
            $R .= $binaryOctalLib[$base];
        }
        return $R;
    }

    /**
     * 二进制转换成十进制数
     *
     * @param string $code
     * @return int
     */
    public static function binaryToDec(string $code): int
    {
        $ta   = str_split($code);
        $base = 1;
        $R    = 0;
        while (count($ta) > 0) {
            $v = array_pop($ta);
            if ($v > 0) {
                $R += $base;
            }
            $base *= 2;
        }
        return intval($R);
    }

    /**
     * 二进制转换成十六进制数
     *
     * @param string $code
     * @return string
     * @throws ProgramException
     */
    public static function binaryToHex(string $code)
    {
        $len = strlen($code);
        $mod = fmod($len, 4);
        if ($mod > 0) {
            $len = $len + 4 - $mod;
        }
        $ta           = str_split(sprintf("%0{$len}s", $code), 4);
        $R            = '';
        $binaryHexLib = self::$binaryHex;
        while (count($ta) > 0) {
            $base = array_shift($ta);
            if (!isset($binaryHexLib[$base])) {
                throw new ProgramException("传递的「{$code}」不是有效的二进制数");
            }
            $R .= $binaryHexLib[$base];
        }
        return $R;
    }

    /**
     * 二进制转换成64进制
     *
     * @param string $code
     * @return string
     * @throws ProgramException
     */
    public static function binaryToBase64(string $code)
    {
        $len = strlen($code);
        $mod = fmod($len, 6);
        if ($mod > 0) {
            $len = $len + 6 - $mod;
        }
        $ta = str_split(sprintf("%0{$len}s", $code), 6);
        $R  = '';
        while (count($ta) > 0) {
            $R .= self::decToBase(self::binaryToDec(array_shift($ta)), 64);
        }
        return $R;
    }

    /**
     * 八进制转换成二进制数
     *
     * @param string $code
     * @return string
     * @throws ProgramException
     */
    public static function octalToBinary(string $code)
    {
        $ta          = str_split($code);
        $octalBinary = array_flip(self::$binaryOctal);
        $R           = '';
        while (count($ta) > 0) {
            $base = array_shift($ta);
            if (!isset($octalBinary[$base])) {
                throw new ProgramException("传递的「{$code}」不是有效的八进制数");
            }
            $R .= $octalBinary[$base];
        }
        return self::formatBinary($R);
    }

    /**
     * 八进制转换成十进制数
     *
     * @param string $code
     * @return float|int
     */
    public static function octalToDec(string $code)
    {
        $ta   = str_split($code);
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
     * @param string $code
     * @return string
     * @throws ProgramException
     */
    public static function octalToHex(string $code)
    {
        return self::binaryToHex(self::octalToBinary($code));
    }

    /**
     * 八进制转换成64进制数
     *
     * @param string $code
     * @return string
     * @throws ProgramException
     */
    public static function octalToBase64(string $code)
    {
        return self::binaryToBase64(self::octalToBinary($code));
    }

    /**
     * 十进制转换成二进制数
     *
     * @param int $n
     * @param int $length 前位补0
     * @return string
     */
    public static function decToBinary($n, int $length = 0)
    {
        $R = '';
        while ($n > 0) {
            $R = ($n & 1) . $R;
            $n = $n >> 1;
        }
        if ($length > 0) {
            return sprintf("%0{$length}s", $R);
        }
        return self::formatBinary($R);
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
        $chars = substr(self::BASE_CHARS, 0, 16);
        $R     = '';
        while ($n > 0) {
            $base = ($n & 15);
            $R    = $chars{$base} . $R;
            $n    = $n >> 4;
        }
        return $R;
    }

    /**
     * 十进制转换成64进制数
     *
     * @param string $n
     * @return string
     */
    public static function decToBase64($n)
    {
        $chars = substr(self::BASE_CHARS, 0, 64);
        $R     = '';
        while ($n > 0) {
            $base = ($n & 63);
            $R    = $chars{$base} . $R;
            $n    = $n >> 6;
        }
        return $R;
    }

    /**
     * 十六进制转换成二进制数
     *
     * @param string $code
     * @return string
     * @throws ProgramException
     */
    public static function hexToBinary(string $code)
    {
        $ta        = str_split(strtolower($code));
        $R         = '';
        $hexBinary = array_flip(self::$binaryHex);
        while (count($ta) > 0) {
            $base = array_shift($ta);
            if (!isset($hexBinary[$base])) {
                throw new ProgramException("传递的「{$code}」不是有效的十六进制数");
            }
            $R .= $hexBinary[$base];
        }
        return self::formatBinary($R);
    }

    /**
     * 十六进制转换成八进制数
     *
     * @param string $code
     * @return string
     * @throws ProgramException
     */
    public static function hexToOctal(string $code)
    {
        return self::binaryToOctal(self::hexToBinary($code));
    }

    /**
     * 十六进制转换成十进制数
     *
     * @param string $code
     * @return float|int
     * @throws ProgramException
     */
    public static function hexToDec(string $code)
    {
        $ta    = str_split(strtolower($code));
        $chars = substr(self::BASE_CHARS, 0, 16);
        $base  = 1;
        $R     = 0;
        while (count($ta) > 0) {
            $v   = array_pop($ta);
            $pos = strpos($chars, $v);
            if (false === $pos) {
                throw new ProgramException("传递的「{$code}」不是有效的十六进制数");
            }
            if ($pos > 0) {
                $R += $base * $pos;
            }
            $base *= 16;
        }
        return $R;
    }

    /**
     * 十六进制转换成64进制数
     *
     * @param string $code
     * @return string
     * @throws ProgramException
     */
    public static function hexToBase64(string $code)
    {
        return self::binaryToBase64(self::hexToBinary($code));
    }

    /**
     * 64进制转换成二进制
     *
     * @param string $code
     * @return string
     * @throws ProgramException
     */
    public static function base64ToBinary(string $code)
    {
        $ta    = str_split($code);
        $chars = self::BASE_CHARS;
        $R     = '';
        while (count($ta) > 0) {
            $pos = strpos($chars, array_shift($ta));
            if (false === $pos) {
                throw new ProgramException("传递的「{$code}」不是有效的十六进制数");
            }
            $R .= self::decToBinary($pos, 6);
        }
        return self::formatBinary($R);
    }

    /**
     * 64进制转换成八进制
     *
     * @param string $code
     * @return string
     * @throws ProgramException
     */
    public static function base64ToOctal(string $code)
    {
        return self::binaryToOctal(self::base64ToBinary($code));
    }

    /**
     * 64进制转换成十进制
     *
     * @param string $code
     * @return string
     * @throws ProgramException
     */
    public static function base64ToDec(string $code)
    {
        $ta    = str_split($code);
        $chars = substr(self::BASE_CHARS, 0, 64);
        $base  = 1;
        $R     = 0;
        while (count($ta) > 0) {
            $v   = array_pop($ta);
            $pos = strpos($chars, $v);
            if (false === $pos) {
                throw new ProgramException("传递的「{$code}」不是有效的十六进制数");
            }
            if ($pos > 0) {
                $R += $base * $pos;
            }
            $base *= 64;
        }
        return $R;
    }

    /**
     * 64进制转换成十六进制
     *
     * @param string $code
     * @return string
     * @throws ProgramException
     */
    public static function base64ToHex(string $code)
    {
        return self::binaryToHex(self::base64ToBinary($code));
    }

    /**
     * 二进制8byte规范
     *
     * @param string $code
     * @return string
     */
    public static function formatBinary(string $code)
    {
        $code = ltrim($code, '0');
        $len  = strlen($code);
        $mod  = fmod($len, 8);
        if ($mod > 0) {
            $len  = $len + 8 - $mod;
            $code = sprintf("%0{$len}s", $code);
        }
        return $code;
    }
}