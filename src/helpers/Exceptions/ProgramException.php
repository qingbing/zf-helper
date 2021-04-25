<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Exceptions;

/**
 * 程序异常
 *
 * Class ProgramException
 * @package Zf\Helper\Exceptions
 */
class ProgramException extends Exception
{
    /**
     * 异常类型
     *
     * @var string
     */
    public $type = 'program';
}