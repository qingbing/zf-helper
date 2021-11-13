<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Traits\Models;


use Zf\Helper\Exceptions\ProgramException;

/**
 * 片段 : 对比关系标签
 *
 * Trait TLabelCompareRelation
 * @package Zf\Helper\Traits\Models
 */
trait TLabelCompareRelation
{
    private static $_compareEntities = [
        COMPARE_EQ => '=',
        COMPARE_NE => '!=',
        COMPARE_GT => '>',
        COMPARE_GE => '>=',
        COMPARE_LT => '<',
        COMPARE_LE => '<=',
    ];

    /**
     * 对比关系标签
     *
     * @return array
     */
    public static function compareLabels()
    {
        return [
            COMPARE_EQ => '等于',
            COMPARE_NE => '不等于',
            COMPARE_GT => '大于',
            COMPARE_GE => '大于等于',
            COMPARE_LT => '小于',
            COMPARE_LE => '小于等于',
        ];
    }

    /**
     * 获取对比关系代码实体
     *
     * @param string|null $code
     * @return array
     * @throws ProgramException
     */
    public static function getCompareEntity(?string $code = null)
    {
        if (null == $code) {
            return self::$_compareEntities;
        }
        if (!isset(self::$_compareEntities[$code])) {
            throw new ProgramException("不存在的对比关系「{$code}」");
        }
        return self::$_compareEntities[$code];
    }
}