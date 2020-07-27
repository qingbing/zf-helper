<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Traits\Models;

/**
 * 删除状态标签 片段
 * Class TDeleteLabel
 * @package Zf\Helper\Traits\Models
 */
class TLabelDelete
{
    /**
     * 删除状态标签
     *
     * @return array
     */
    public static function deleteLabels()
    {
        return [
            IS_DELETE_NO  => '正常',
            IS_DELETE_YES => '已删除',
        ];
    }
}