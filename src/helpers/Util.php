<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper;

/**
 * 功能集合
 *
 * Class Util
 * @package Zf\Helper
 */
class Util
{
    /**
     * 内存单位转换
     *
     * @param string $size
     * @param string $targetUnit
     * @param string $sourceUnit
     * @return string|null
     */
    public static function switchMemoryCapacity($size, string $targetUnit = 'KB', string $sourceUnit = 'B'): ?string
    {
        $supportUnit = [
            'B'  => 1,
            'KB' => 2,
            'MB' => 3,
            'GB' => 4,
            'TB' => 5,
        ];
        $targetUnit  = strtoupper($targetUnit);
        if (!isset($supportUnit[$targetUnit])) {
            return null;
        }
        if (is_numeric($size)) {
            $size       = floatval($size);
            $sourceUnit = strtoupper($sourceUnit);
        } else {
            $size = strtoupper($size);
            if (preg_match('#^(\d*(\.\d*)?)(.*)$#', $size, $m)) {
                $size       = $m[1];
                $sourceUnit = $m[3];
                if (!isset($supportUnit[$sourceUnit])) {
                    return "0 {$targetUnit}";
                }
            } else {
                return "0 {$targetUnit}";
            }
        }
        return sprintf('%.2f', $size * pow(1024, $supportUnit[$sourceUnit] - $supportUnit[$targetUnit])) . " {$targetUnit}";
    }
}