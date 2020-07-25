<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Traits;

/**
 * 为 $this 对象的属性赋值
 *
 * Class TConfigure
 * @package Zf\Helper\Traits
 */
trait TConfigure
{
    /**
     * 为 $this 对象的属性赋值
     *
     * @param array $properties
     * @param bool $strict
     */
    public function configure(array $properties = null, $strict = false)
    {
        if (empty($properties)) {
            return;
        }
        if ($strict) {
            foreach ($properties as $property => $value) {
                // 对象定义了该属性才为属性赋值
                if (property_exists($this, $property)) {
                    $this->{$property} = $value;
                }
            }
        } else {
            // 对象属性赋值
            foreach ($properties as $property => $value) {
                $this->{$property} = $value;
            }
        }
    }
}