<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Transfor;

use Zf\Helper\Exceptions\ProgramException;

/**
 * Unicode码转换
 * 简单描述: Utf-8字符编码转换成Unicode参考下面列表，将"x"从后向前排列，位数补足8的倍数(前位补0)
 *
 * U-00000000 - U-0000007F: 0xxxxxxx => 1*0 + 1u
 * U-00000080 - U-000007FF: 110xxxxx 10xxxxxx => 5*0 + 2u
 * U-00000800 - U-0000FFFF: 1110xxxx 10xxxxxx 10xxxxxx => 0*0 + 2u
 * U-00010000 - U-001FFFFF: 11110xxx 10xxxxxx 10xxxxxx 10xxxxxx => 3*0 + 3u
 * U-00200000 - U-03FFFFFF: 111110xx 10xxxxxx 10xxxxxx 10xxxxxx 10xxxxxx => 6*0 + 4u
 * U-04000000 - U-7FFFFFFF: 1111110x 10xxxxxx 10xxxxxx 10xxxxxx 10xxxxxx 10xxxxxx => 1*0 + 4u
 *
 * Class UnicodeHelper
 * @package Zf\Helper\Transfor
 */
class UnicodeHelper
{
    /**
     * 将字符串转换成utf-8的进制编码
     *
     * @param string|int $string
     * @param string $type
     * @return string
     * @throws ProgramException
     */
    public static function string2Unicode8($string, $type = NumberHelper::TYPE_HEX)
    {
        $len  = strlen($string);
        $code = '';
        for ($i = 0; $i < $len; $i++) {
            $code .= NumberHelper::decToBinary(ord($string{$i}), 8);
        }
        switch ($type) {
            case NumberHelper::TYPE_OCTAL: // octal
                return NumberHelper::binaryToOctal($code);
            case NumberHelper::TYPE_HEX: // hex
                return NumberHelper::binaryToHex($code);
            case NumberHelper::TYPE_BASE64: // base64
                return NumberHelper::binaryToBase64($code);
            default:
                return $code;
        }
    }

    /**
     * 将utf-8的进制编码转换成字符串
     *
     * @param string $code
     * @param string $type
     * @return string
     * @throws ProgramException
     */
    public static function unicode82String($code, $type = NumberHelper::TYPE_HEX)
    {
        switch ($type) {
            case NumberHelper::TYPE_OCTAL: // octal
                $code = NumberHelper::octalToBinary($code);
                break;
            case NumberHelper::TYPE_HEX: // hex
                $code = NumberHelper::hexToBinary($code);
                break;
            case NumberHelper::TYPE_BASE64: // base64
                $code = NumberHelper::base64ToBinary($code);
                break;
            default:
        }
        $tCodes  = str_split(NumberHelper::formatBinary($code), 8);
        $rString = '';
        for ($i = 0; $i < count($tCodes); $i++) {
            $rString .= chr(NumberHelper::binaryToDec($tCodes[$i]));
        }
        return $rString;
    }

    /**
     * 将字符(UTF-8)转换成unicode编码
     *
     * @param string $char
     * @param int $length
     * @return int|string
     */
    public static function char2Unicode($char, $length = 0)
    {
        switch (strlen($char)) {
            case 1:
                $code = ord($char);
                break;
            case 2:
                $code = ((ord($char{0}) & 0x1F) << 6)
                    | (ord($char{1}) & 0x3F);
                break;
            case 3:
                $code = ((ord($char{0}) & 0xF) << 12)
                    | ((ord($char{1}) & 0x3F) << 6)
                    | (ord($char{2}) & 0x3F);
                break;
            case 4:
                $code = ((ord($char{0}) & 0x7) << 18)
                    | ((ord($char{1}) & 0x3F) << 12)
                    | ((ord($char{2}) & 0x3F) << 6)
                    | (ord($char{3}) & 0x3F);
                break;
            case 5:
                $code = ((ord($char{0}) & 0x3) << 24)
                    | ((ord($char{1}) & 0x3F) << 18)
                    | ((ord($char{2}) & 0x3F) << 12)
                    | ((ord($char{3}) & 0x3F) << 6)
                    | (ord($char{4}) & 0x3F);
                break;
            case 6:
                $code = ((ord($char{0}) & 0x1) << 32)
                    | ((ord($char{1}) & 0x3F) << 24)
                    | ((ord($char{2}) & 0x3F) << 18)
                    | ((ord($char{3}) & 0x3F) << 12)
                    | ((ord($char{4}) & 0x3F) << 6)
                    | (ord($char{5}) & 0x3F);
                break;
            default:
                return '';
        }
        $code = dechex($code);
        if ($length > 0) {
            return sprintf("%0{$length}s", $code);
        }
        return $code;
    }

    /**
     * unicode码转换成utf-8字符
     *
     * @param mixed $unicode
     * @return bool|string
     */
    public static function unicode2Char($unicode)
    {
        if (!is_int($unicode)) {
            $unicode = intval(hexdec($unicode));
        }
        if ($unicode < 128) {
            return chr($unicode);
        }
        $len = 1;
        $chr = '';
        while (true) {
            $len++;
            $chr     = chr(($unicode & 0x3F) + 0x80) . $chr;
            $unicode >>= 6;
            if ($unicode < 64) {
                return chr(((254 << (7 - $len)) & 255) | $unicode) . $chr;
            }
        }
        return false;
    }

    /**
     * 将字符串转换成unicode的进制编码
     *
     * @param string $string
     * @param string $type
     * @param int $unicodeByte 单个字符占用的字节长度
     * @return string
     * @throws ProgramException
     */
    public static function string2Unicode($string, $type = NumberHelper::TYPE_HEX, $unicodeByte = 4)
    {
        $len  = strlen($string);
        $code = '';
        for ($i = 0; $i < $len; $i++) {
            $ord = ord($string{$i});
            if ($ord < 128) { // length=1 => 1u
                $char = $string{$i};
                $_len = 1;
            } elseif ($ord < 224) { // length=2 => 2u
                $char = $string{$i} . $string{++$i};
                $_len = 2;
            } elseif ($ord < 240) { // length=3 => 3u
                $char = $string{$i} . $string{++$i} . $string{++$i};
                $_len = 3;
            } elseif ($ord < 248) { // length=4 => 3u
                $char = $string{$i} . $string{++$i} . $string{++$i} . $string{++$i};
                $_len = 3;
            } elseif ($ord < 252) { // length=5 => 4u
                $char = $string{$i} . $string{++$i} . $string{++$i} . $string{++$i} . $string{++$i};
                $_len = 4;
            } elseif ($ord < 254) { // length=6 => 4u
                $char = $string{$i} . $string{++$i} . $string{++$i} . $string{++$i} . $string{++$i} . $string{++$i};
                $_len = 4;
            } else {
                throw new ProgramException('字符串编码有无');
            }
            if ($_len > $unicodeByte) {
                throw new ProgramException("字符{$char}不能在{$unicodeByte}字节里表示");
            }
            $code .= self::char2Unicode($char, $unicodeByte);
        }
        $code = ltrim($code, '0');
        switch ($type) {
            case NumberHelper::TYPE_BINARY : // binary
                return NumberHelper::hexToBinary($code);
            case NumberHelper::TYPE_OCTAL : // octal
                return NumberHelper::hexToOctal($code);
            case NumberHelper::TYPE_BASE64 : // base64
                return NumberHelper::hexToBase64($code);
            default: // hex
                return $code;
        }
    }

    /**
     * 将unicode的进制编码转换成字符串
     *
     * @param string $code
     * @param string $type
     * @param int $unicodeByte 单个字符占用的字节长度
     * @return string
     * @throws ProgramException
     */
    public static function unicode2String($code, $type = NumberHelper::TYPE_HEX, $unicodeByte = 4)
    {
        switch ($type) {
            case NumberHelper::TYPE_BINARY: // binary
                $code = NumberHelper::binaryToHex($code);
                break;
            case NumberHelper::TYPE_OCTAL: // octal
                $code = NumberHelper::octalToHex($code);
                break;
            case NumberHelper::TYPE_BASE64: // base64
                $code = NumberHelper::base64ToHex($code);
                break;
            default:
        }
        $len = strlen($code);
        $mod = fmod($len, $unicodeByte);
        if ($mod > 0) {
            $len = $len + $unicodeByte - $mod;
        }
        $tCodes  = str_split(sprintf("%0{$len}s", $code), $unicodeByte);
        $rString = '';
        for ($i = 0; $i < count($tCodes); $i++) {
            $rString .= self::unicode2Char($tCodes[$i]);
        }
        return $rString;
    }
}