<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Abstracts;

/**
 * 单例模式基类
 *
 * Class Singleton
 * @package Zf\Helper\Abstracts
 */
abstract class Singleton extends Base
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
     * @return Singleton
     */
    public static function getInstance(): Singleton
    {
        $className = static::class;
        if (!isset(self::$_instances[$className])) {
            $class = new $className();
            // 相当于类的构造函数函数
            /* @var $class $this */
            $class->init();
            self::$_instances[$className] = $class;
        }
        return self::$_instances[$className];
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