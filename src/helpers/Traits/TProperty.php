<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Traits;

use Zf\Helper\Exceptions\PropertyException;

/**
 * 属性判断和处理
 *
 * Trait TProperty
 * @package Zf\Helper\Traits
 */
trait TProperty
{
    /**
     * 魔术方法：$obj->{$property} = $value 时，调用该函数
     *
     * @param string $property
     * @param mixed $value
     *
     * @throws PropertyException
     */
    public function __set(string $property, $value)
    {
        if (null !== ($setter = $this->setterName($property))) {
            $this->$setter($value);
        } else if (null !== $this->getterName($property)) {
            throw new PropertyException(interpolate('尝试写入read-only属性"{class}.{property}"', [
                'class'    => get_class($this),
                'property' => $property,
            ]), 1010001001);
        } else {
            throw new PropertyException(interpolate('尝试写入不存在的属性"{class}.{property}"', [
                'class'    => get_class($this),
                'property' => $property,
            ]), 1010001002);
        }
    }

    /**
     * 魔术方法：$obj->{$property} ,如果 $property 不存在时调用
     *
     * @param string $property
     * @return mixed|null
     *
     * @throws PropertyException
     */
    public function __get(string $property)
    {
        if (null !== ($getter = $this->getterName($property))) {
            return $this->{$getter}();
        }
        if (null !== $this->setterName($property)) {
            throw new PropertyException(interpolate('尝试读取write-only属性"{class}.{property}"。', [
                'class'    => get_class($this),
                'property' => $property,
            ]), 1010001003);
        } else {
            throw new PropertyException(interpolate('尝试读取不存在的属性"{class}.{property}"', [
                'class'    => get_class($this),
                'property' => $property,
            ]), 1010001004);
        }
    }

    /**
     * 魔术方法：unset($obj->{$property})时调用
     *
     * @param string $property
     *
     * @throws PropertyException
     */
    public function __unset(string $property)
    {
        if (null !== ($setter = $this->setterName($property))) {
            $this->$setter(null);
        } else if (null !== $this->getterName($property)) {
            throw new PropertyException(interpolate('尝试删除read-only属性"{class}.{property}"', [
                'class'    => get_class($this),
                'property' => $property,
            ]), 1010001005);
        }
    }

    /**
     * 魔术方法：isset($obj->{$property})时调用
     *
     * @param string $property
     * @return bool
     */
    public function __isset(string $property): bool
    {
        if (null !== ($getter = $this->getterName($property))) {
            return null !== $this->$getter();
        } else {
            return false;
        }
    }

    /**
     * 判断属性是否可读
     *
     * @param string $property
     * @return bool
     */
    public function canGetProperty(string $property): bool
    {
        return null !== $this->getterName($property);
    }

    /**
     * 判断属性是否可写
     *
     * @param string $property
     * @return bool
     */
    public function canSetProperty(string $property): bool
    {
        return null !== $this->setterName($property);
    }

    /**
     * 检查属性是否存在
     *
     * @param string $property
     * @return bool
     */
    public function hasProperty(string $property): bool
    {
        return null !== $this->getterName($property) || null !== $this->setterName($property);
    }

    /**
     * 获取类属性的 __get 真实方法名
     *
     * @param string $property
     * @return string | null
     */
    protected function getterName(string $property)
    {
        $getter = 'get' . $property;
        if (method_exists($this, $getter)) {
            return $getter;
        }
        /*$getter = 'is' . $property;
        if (method_exists($this, $getter)) {
            return $getter;
        }*/
        return null;
    }

    /**
     * 获取类属性的 __set 真实方法名
     *
     * @param string $property
     * @return string | null
     */
    protected function setterName(string $property)
    {
        $setter = 'set' . $property;
        if (method_exists($this, $setter)) {
            return $setter;
        }
        return null;
    }
}