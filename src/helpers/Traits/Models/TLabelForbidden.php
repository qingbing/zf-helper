<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Traits\Models;

/**
 * 禁用状态标签 片段
 *
 * Class TForbiddenLabels
 * @package Zf\Helper\Traits\Models
 */
trait TLabelForbidden
{
    /**
     * 禁用状态标签
     *
     * @return array
     */
    public static function forbiddenLabels()
    {
        return [
            IS_FORBIDDEN_NO  => '启用',
            IS_FORBIDDEN_YES => '禁用',
        ];
    }
}