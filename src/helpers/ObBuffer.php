<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper;

/**
 * Ob 缓冲管理
 *
 * Class ObBuffer
 * @package Zf\Helper
 */
class ObBuffer
{
    /**
     * 开始缓冲区
     */
    public static function start()
    {
        ob_start();
        ob_implicit_flush(false);
    }

    /**
     * 结束缓冲区
     *
     * @param bool $return
     * @return false|string|void
     */
    public static function end($return = true)
    {
        if ($return) {
            return ob_get_clean();
        }
        echo ob_get_clean();
    }
}