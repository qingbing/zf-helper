<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Traits\Models;


use Zf\Helper\Exceptions\ProgramException;

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

    /**
     * 检验有效的排序代码
     *
     * @param string $code
     * @return array
     * @throws ProgramException
     */
    public static function getOrderByEntity($code)
    {
        $orderCodes = self::orderByLabels();
        if (null == $code) {
            return $orderCodes;
        }
        if (!isset($orderCodes[$code])) {
            throw new ProgramException("不存在的排序代码「{$code}」");
        }
        return $code;
    }
}