<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Abstracts;

use Zf\Helper\Traits\TConfigure;
use Zf\Helper\Traits\TProperty;

/**
 * Zf 基类
 *
 * Class Base
 * @package Zf\Helper\Abstracts
 */
abstract class Base
{
    /**
     * 使用 $this 属性赋值
     */
    use TConfigure;
    /**
     * 属性判断和处理
     */
    use TProperty;
}