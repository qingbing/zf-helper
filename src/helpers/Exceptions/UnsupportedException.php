<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Exceptions;


/**
 * 不支持的业务异常
 *
 * Class UnsupportedException
 * @package Zf\Helper\Exceptions
 */
class UnsupportedException extends BusinessException
{
    /**
     * 异常类型
     *
     * @var string
     */
    public $type = 'unsupported';
}