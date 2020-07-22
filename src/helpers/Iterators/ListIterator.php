<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Iterators;


/**
 * List 迭代器实现
 *
 *      实现该类，对象将可以像数组一样拥有遍历功能（可以自定定义遍历或使用foreach）
 *      $obj->current();  对应使用 \Iterator.current()  : 返回当前所在游标对象
 *      $obj->next();     对应使用 \Iterator.next()     : 将对象游标向下移位
 *      $obj->key();      对应使用 \Iterator.key()      : 返回当前所在游标
 *      $obj->valid();    对应使用 \Iterator.valid()    : 返回当前游标是否有效
 *      $obj->rewind();   对应使用 \Iterator.rewind()   : 将游标重置到开始位置
 *
 * Class ListIterator
 * @package Zf\Helper\Iterators
 */
class ListIterator implements \Iterator
{
    /**
     * 数据存储
     *
     * @var array
     */
    private $_items;
    /**
     * 当前 list 索引
     *
     * @var int
     */
    private $_index;

    /**
     * 魔术方法：构造方法
     * @param array $data
     */
    public function __construct(array &$data)
    {
        $this->_items =& $data;
        $this->_index = 0;
    }

    /**
     * @inheritDoc   Iterator
     * current ： 返回遍历的当前数据
     *
     * @return mixed
     * @since 5.0.0
     */
    public function current()
    {
        return $this->_items[$this->_index];
    }

    /**
     * @inheritDoc   Iterator
     * next : 索引或键向后移动一位
     *
     * @since 5.0.0
     */
    public function next()
    {
        $this->_index++;
    }

    /**
     * @inheritDoc   Iterator
     * key ： 返回当前迭代索引或键
     *
     * @return int|mixed
     * @since 5.0.0
     */
    public function key()
    {
        return $this->_index;
    }

    /**
     * @inheritDoc   Iterator
     * valid ： 判断是否索引继续有效
     *
     * @return bool
     * @since 5.0.0
     */
    public function valid()
    {
        return $this->_index < count($this->_items);
    }

    /**
     * @inheritDoc   Iterator
     * rewind ： 重置索引或键
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->_index = 0;
    }
}