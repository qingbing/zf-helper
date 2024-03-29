<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Traits\Models;

/**
 * 片段 : 启用状态标签
 *
 * Trait TEnableLabel
 * @package Zf\Helper\Traits\Models
 */
trait TLabelEnable
{
    /**
     * 启用状态标签
     *
     * @return array
     */
    public static function enableLabels()
    {
        return [
            IS_ENABLE_NO  => '禁用',
            IS_ENABLE_YES => '启用',
        ];
    }
}