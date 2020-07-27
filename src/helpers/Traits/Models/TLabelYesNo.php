<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Traits\Models;

/**
 * 是否标签 片段
 * Class TIsLabel
 * @package Zf\Helper\Traits\Models
 */
trait TLabelYesNo
{
    /**
     * 是否标签
     *
     * @return array
     */
    public static function isLabels()
    {
        return [
            IS_NO  => '否',
            IS_YES => '是',
        ];
    }

    /**
     * 是否标签
     *
     * @return array
     */
    public static function yesNoLabels()
    {
        return [
            IS_NO  => '否',
            IS_YES => '是',
        ];
    }
}