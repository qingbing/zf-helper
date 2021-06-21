<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Traits;

defined("OPTION_TYPE_OBJECT") or define("OPTION_TYPE_OBJECT", "object");
defined("OPTION_TYPE_ID_VALUE") or define("OPTION_TYPE_ID_VALUE", "id-value");

/**
 * 片段 ： 格式化前端选项
 *
 * Class TOptionFormat
 * @package Zf\Helper\Traits
 */
trait TOptionFormat
{
    /**
     * 格式化选项输出
     *
     * @param array $data
     * @param string $idField
     * @param string $valueField
     * @param string $type
     * @return array
     */
    protected function optionFormat(array $data, $idField = 'id', string $valueField = 'value', $type = OPTION_TYPE_OBJECT)
    {
        $R = [];
        switch ($type) {
            case OPTION_TYPE_ID_VALUE:
                foreach ($data as $datum) {
                    array_push($R, ['id' => $datum[$idField], 'value' => $datum[$valueField]]);
                }
                break;
            case OPTION_TYPE_OBJECT:
                foreach ($data as $datum) {
                    $R[$datum[$idField]] = $datum[$valueField];
                }
            default:
                break;
        }
        return $R;
    }
}