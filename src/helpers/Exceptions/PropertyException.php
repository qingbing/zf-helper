<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Exceptions;

/**
 * 属性异常
 *
 * Class PropertyException
 * @package Zf\Helper\Exceptions
 */
class PropertyException extends Exception
{
    /**
     * 异常类型
     *
     * @var string
     */
    public $type = 'property';
}