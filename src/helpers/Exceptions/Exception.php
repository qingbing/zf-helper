<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Exceptions;


use Throwable;

/**
 * 异常基类
 *
 * Class Exception
 * @package Zf\Helper\Exceptions
 */
class Exception extends \Exception
{
    /**
     * 异常类型
     *
     * @var string
     */
    public $type = 'base';

    /**
     * 魔术方法：重置异常构造函数，使得code优先
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", int $code = -1, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}