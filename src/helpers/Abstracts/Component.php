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
     * 魔术方法：构造函数， final 化，不允许覆盖
     */
    final public function __construct()
    {
    }

    /**
     * 属性赋值后执行函数
     */
    public function init()
    {
    }
}