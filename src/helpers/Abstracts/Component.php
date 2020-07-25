<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Abstracts;

/**
 * 自定义组件基类
 *
 * Class Component
 * @package Zf\Helper\Abstracts
 */
abstract class Component extends Base
{
    /**
     * 魔术方法：构造函数，禁用外部 new
     */
    final private function __construct()
    {
    }

    /**
     * 存储实例
     *
     * @var array
     */
    private static $_instances = [];

    /**
     * 获取实例
     *
     * @return $this
     */
    public static function getInstance(array $config = null): Component
    {
        $className = static::class;
        $hashKey   = $className . serialize($config);
        if (!isset(self::$_instances[$hashKey])) {
            $class = new $className();
            // 相当于类的构造函数函数
            /* @var $class $this */
            $class->configure($config);
            $class->init();
            self::$_instances[$hashKey] = $class;
        }
        return self::$_instances[$hashKey];
    }

    /**
     * 构造函数后执行
     */
    protected function init()
    {
    }

    /**
     * 魔术方法：禁用实例 clone
     */
    final private function __clone()
    {
    }
}