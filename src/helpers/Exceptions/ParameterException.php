<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Exceptions;

/**
 * 参数异常
 *
 * Class ParameterException
 * @package Zf\Helper\Exceptions
 */
class ParameterException extends Exception
{
    /**
     * 异常类型
     *
     * @var string
     */
    public $type = 'parameter';
}