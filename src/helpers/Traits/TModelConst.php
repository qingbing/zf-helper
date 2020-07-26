<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Traits;

/**
 * 模型的通用常量定义
 *
 * Trait TModelConst
 * @package Zf\Helper\Traits
 */
trait TModelConst
{
    /**
     * 性别标签
     *
     * @return array
     */
    public static function sexes()
    {
        return [
            SEX_UNKNOWN => '密码',
            SEX_MALE    => '男',
            SEX_FEMALE  => '女',
        ];
    }

}