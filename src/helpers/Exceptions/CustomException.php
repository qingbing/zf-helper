<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Exceptions;

/**
 * 用户自定义异常
 *
 * Class CustomException
 * @package Zf\Helper\Exceptions
 */
class CustomException extends Exception
{
    /**
     * 异常类型
     *
     * @var string
     */
    public $type = 'custom';
}