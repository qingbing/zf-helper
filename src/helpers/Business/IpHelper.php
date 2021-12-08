<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Business;

/**
 * Ip 地址助手
 *
 * Class IpHelper
 * @package Zf\Helper\Business
 */
class IpHelper
{
    /**
     * ip 配置范围检查
     *
     * @param mixed $ip
     * @param string $range 支持多种写法
     *  - ip : 1.2.3.10
     *  - wildcard : 1.2.3.*
     *  - start-end : 1.2.3.0～1.2.3.255
     *  - cird : 1.2.3.1/24 或者 1.2.3.1/255.255.255.0
     * @return bool
     */
    public static function inRange($ip, $range): bool
    {
        // CIDR 方式设置的ip范围 IP/NETMASK
        if (false !== strpos($range, '/')) {
            list($range, $netmask) = explode('/', $range, 2);
            $x = explode('.', $range);
            while (count($x) < 4) {
                $x[] = '0';
            }
            foreach ($x as $k => $v) {
                if (empty($v)) {
                    $x[$k] = '0';
                }
            }
            list($a, $b, $c, $d) = $x;
            $range = sprintf('%u.%u.%u.%u', $a, $b, $c, $d);
            if (false !== strpos($netmask, '.')) {
                // netmask : 1.2.3.*
                $netmask     = str_replace('*', '0', $netmask);
                $netmaskLong = ip2long($netmask);
                return (ip2long($ip) & $netmaskLong) == (ip2long($range) & $netmaskLong);
            }
            // netmask : /24(CIDR)
            $cidrLong    = pow(2, (32 - $netmask)) - 1;
            $netmaskLong = ~$cidrLong;
            return (ip2long($ip) & $netmaskLong) == (ip2long($range) & $netmaskLong);
        }
        // 1.2.3.* 转换成 1.2.3.0～1.2.3.255
        if (false !== strpos($range, '*')) {
            $lower = str_replace('*', '0', $range);
            $upper = str_replace('*', '255', $range);
            $range = "{$lower}~{$upper}";
        }
        // 对比 ip 是否在 1.2.3.0～1.2.3.255 包含内
        if (false !== strpos($range, '~')) {
            list($lower, $upper) = explode('~', $range, 2);
            $lowerLong = (float)sprintf('%u', ip2long($lower));
            $upperLong = (float)sprintf('%u', ip2long($upper));
            $ipLong    = (float)sprintf('%u', ip2long($ip));
            return $ipLong >= $lowerLong && $ipLong <= $upperLong;
        }
        // 具体的ip比较
        return bindec(decbin(ip2long($ip))) == bindec(decbin(ip2long($range)));
    }

    /**
     * ip 是否在一些列范围中
     *
     * @param mixed $ip
     * @param mixed $ranges
     *      - [1.2.3.1/24, 172.1.100.1, 127.2.2.2]
     *      - 1.2.3.1/24|172.1.100.1|127.2.2.2
     * @return bool
     */
    public static function inRanges($ip, $ranges): bool
    {
        if (empty($range)) {
            return true;
        }
        if (!is_array($ranges)) {
            $ranges = explode_data($ranges, '|');
        }
        foreach ($ranges as $val) {
            if (self::inRange($ip, $val)) {
                return true;
            }
        }
        return false;
    }
}