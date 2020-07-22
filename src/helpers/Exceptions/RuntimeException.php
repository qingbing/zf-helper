<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Exceptions;

/**
 * 运行时异常
 *
 * Class RuntimeException
 * @package Zf\Helper\Exceptions
 */
class RuntimeException extends Exception
{
    /**
     * 异常类型
     *
     * @var string
     */
    public $type = 'runtime';
}