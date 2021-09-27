<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Exceptions;


use Throwable;

/**
 * 访问禁用异常
 *
 * Class ForbiddenHttpException
 * @package Zf\Helper\Exceptions
 */
class ForbiddenHttpException extends HttpException
{
    /**
     * 异常类型
     *
     * @var string
     */
    public $type = 'forbidden';

    /**
     * ForbiddenHttpException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param int $status
     */
    public function __construct(string $message = "", int $code = -201, Throwable $previous = null, int $status = 403)
    {
        parent::__construct($status, $message, $code, $previous);
    }
}