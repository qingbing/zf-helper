<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Exceptions;


use Throwable;

/**
 * 不存在界面异常
 *
 * Class NotFoundHttpException
 * @package Zf\Helper\Exceptions
 */
class NotFoundHttpException extends HttpException
{
    /**
     * 异常类型
     *
     * @var string
     */
    public $type = 'NotFound';

    /**
     * NotFoundHttpException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param int $status
     */
    public function __construct(string $message = "", int $code = -201, Throwable $previous = null, int $status = 404)
    {
        parent::__construct($status, $message, $code, $previous);
    }
}