<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Traits\Models;

/**
 * 性别标签 片段
 *
 * Class TSexLabel
 * @package Zf\Helper\Traits\Models
 */
trait TLabelSex
{
    /**
     * 性别标签
     *
     * @return array
     */
    public static function sexLabels()
    {
        return [
            SEX_UNKNOWN => '密码',
            SEX_MALE    => '男士',
            SEX_FEMALE  => '女士',
        ];
    }
}