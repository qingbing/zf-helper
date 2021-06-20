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
     * 获取当前一个唯一的id，字符截取方式
     *      当前时间 ： 16进制数据获取最后8个字符串
     *      主机ID ： 16进制数据获取最后8个字符串
     *      当前进程ID ：16进制数据获取最后8个字符串
     *      唯一ID ： 16进制数据获取最后8个字符串
     * @return string
     */
    public static function uniqid(): string
    {
        // 当前时间
        $now = substr(dechex(microtime(true)), -8, 8);
        if (false === ($hostname = gethostname())) {
            $hostname = php_uname('n');
        }
        // ip
        $ip = substr(dechex(ip2long(gethostbyname($hostname))), -8, 8);
        // getmypid() : 获取 PHP 进程的 ID
        $pid = substr(dechex(getmypid()), -4, 4);
        // 唯一ID
        $uniqid = substr(uniqid(), -12, 12);
        return sprintf("%'f8s%'f8s%'f4s%s", $now, $ip, $pid, $uniqid);
    }

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

    /**
     * 根据给定的键过滤数组
     *
     * @param array $arr
     * @param array|null $keys
     * @return array
     */
    public static function filterArrayByKeys(array $arr, ?array $keys = [])
    {
        if (empty($keys)) {
            return [];
        }
        $R = [];
        foreach ($keys as $key) {
            if (!isset($arr[$key])) {
                continue;
            }
            $R[$key] = $arr[$key];
        }
        return $R;
    }
}