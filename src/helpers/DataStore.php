<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper;

/**
 * 上下文容器（数据容器），数据登记容器
 *
 * Class Context
 * @package Zf\Helper
 */
final class DataStore
{
    private static $_data = [];

    /**
     * 获取登记信息
     *
     * @param string $name
     * @param mixed $default
     * @return mixed|null
     */
    public static function get(string $name, $default = null)
    {
        return isset(self::$_data[$name]) ? self::$_data[$name] : $default;
    }

    /**
     * 设置登记信息
     *
     * @param string $name
     * @param mixed $value
     */
    public static function set(string $name, $value = null)
    {
        self::$_data[$name] = $value;
    }

    /**
     * 删除一个登记信息
     *
     * @param string $name
     *
     * @return bool
     */
    public static function del(string $name): bool
    {
        if (isset(self::$_data[$name])) {
            unset(self::$_data[$name]);
        }
        return true;
    }

    /**
     * 检测是否存在
     *
     * @param string $name
     *
     * @return bool
     */
    public static function has(string $name): bool
    {
        return isset(self::$_data[$name]);
    }
}