<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper;

/**
 * 获取一个唯一的ID
 *
 * Class Id
 * @package Zf\Helper
 */
class Id
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
}
