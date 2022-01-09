<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Transfor;

/**
 * 辅助类: 标点符号转换
 *
 * Class SymbolHelper
 * @package Zf\Helper\Transfor
 */
class SymbolHelper
{
    /**
     * 半角转换成全角
     *
     * @param string $string
     * @return string
     */
    public static function halfAngle2FullWidth($string)
    {
        return preg_replace_callback('#[\x{0020}-\x{7e}]#u', function ($char) {
            $code = NumberHelper::hexToDec(UnicodeHelper::char2Unicode($char[0]));
            if ($code == 0x0020) { // 0x0020 是空格，特殊处理
                return UnicodeHelper::unicode2Char(0x3000);
            }
            // 半角字符编码 +0xfee0 即可以转为全角
            $code += 0xfee0;
            if ($code > 256) {
                return UnicodeHelper::unicode2Char($code);
            }
            return chr($code);
        }, $string);
    }

    /**
     * 全角转换成半角
     *
     * @param string $string
     * @return string
     */
    public static function fullWidth2HalfAngle($string)
    {
        return preg_replace_callback('#[\x{3000}\x{ff01}-\x{ff5f}]#u', function ($char) {
            $code = NumberHelper::hexToDec(UnicodeHelper::char2Unicode($char[0]));
            if ($code == 0x3000) { // 0x3000 是空格，特殊处理
                return UnicodeHelper::unicode2Char(0x0020);
            }
            // 全角字符编码 -0xfee0 即可以转为半角
            $code -= 0xfee0;
            if ($code > 256) {
                return UnicodeHelper::unicode2Char($code);
            }
            return chr($code);
        }, $string);
    }
}
