<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Traits\Models;


/**
 * 片段 : 排序标签
 *
 * Trait TLabelOrderBy
 * @package Zf\Helper\Traits\Models
 */
trait TLabelOrderBy
{
    /**
     * 排序标签
     *
     * @return array
     */
    public static function orderByLabels()
    {
        return [
            ORDER_ASC  => '升序',
            ORDER_DESC => '降序',
        ];
    }
}