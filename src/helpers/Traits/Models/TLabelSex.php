<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Traits\Models;

/**
  片段 : 性别标签
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
            SEX_UNKNOWN => '秘密',
            SEX_MALE    => '男士',
            SEX_FEMALE  => '女士',
        ];
    }
}