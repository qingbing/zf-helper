<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Exceptions;

/**
 * 类异常
 *
 * Class ClassException
 * @package Zf\Helper\Exceptions
 */
class ClassException extends Exception
{
    /**
     * 异常类型
     *
     * @var string
     */
    public $type = 'class';
}