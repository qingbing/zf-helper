<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Abstracts;

/**
 * 工厂模式基类
 *
 * Class Factory
 * @package Zf\Helper\Abstracts
 */
abstract class Factory extends Base
{
    /**
     * 魔术方法：构造函数，禁用外部 new
     */
    private function __construct()
    {
    }

    /**
     * 获取实例
     *
     * @return $this
     */
    final public static function getInstance(): Factory
    {
        $className = static::class;
        $class     = new $className();
        // 相当于类的构造函数函数
        /* @var $class $this */
        // 相当于类的构造函数函数
        $class->init();
        return $class;
    }

    /**
     * 构造函数后执行，子类可以覆盖
     */
    protected function init()
    {
    }
}