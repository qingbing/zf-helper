<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Iterators;


/**
 * Map 迭代器实现
 *
 *      实现该类，对象将可以像数组一样拥有遍历功能（可以自定定义遍历或使用foreach）
 *      $obj->current();  对应使用 \Iterator.current()  : 返回当前所在游标对象
 *      $obj->next();     对应使用 \Iterator.next()     : 将对象游标向下移位
 *      $obj->key();      对应使用 \Iterator.key()      : 返回当前所在游标
 *      $obj->valid();    对应使用 \Iterator.valid()    : 返回当前游标是否有效
 *      $obj->rewind();   对应使用 \Iterator.rewind()   : 将游标重置到开始位置
 *
 * Class MapIterator
 * @package Zf\Helper\Iterators
 */
class MapIterator implements \Iterator
{
    /**
     * 迭代的数据
     *
     * @var array
     */
    private $_data;
    /**
     * 迭代的键数组集合
     *
     * @var array
     */
    private $_keys;
    /**
     * 当前键名
     *
     * @var mixed
     */
    private $_key;

    /**
     * 模塑方法：构造函数
     *
     * @param mixed $data
     **/
    public function __construct(&$data = [])
    {
        $this->_data =& $data;
        $this->_keys = array_keys($data);
        $this->_key  = reset($this->_keys);
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
        return $this->_data[$this->_key];
    }

    /**
     * @inheritDoc   Iterator
     * next : 索引或键向后移动一位
     *
     * @since 5.0.0
     */
    public function next()
    {
        $this->_key = next($this->_keys);
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
        return $this->_key;
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
        return false !== $this->_key;
    }

    /**
     * @inheritDoc
     * rewind ： 重置索引或键
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->_key = reset($this->_keys);
    }
}