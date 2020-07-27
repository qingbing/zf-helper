<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Exceptions;

/**
 * 业务异常
 *
 * Class BusinessException
 * @package Zf\Helper\Exceptions
 */
class BusinessException extends Exception
{
    /**
     * 异常类型
     *
     * @var string
     */
    public $type = 'business';
}