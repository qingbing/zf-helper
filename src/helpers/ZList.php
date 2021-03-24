<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper;

use \Traversable;
use Zf\Helper\Exceptions\Exception;
use Zf\Helper\Exceptions\ParameterException;
use Zf\Helper\Iterators\ListIterator;
use Zf\Helper\Traits\TProperty;

/**
 * 列表：提供push，pop，unshift，shift等操作
 *
 *      \ArrayAccess 将数组提供出来像数组一样使用
 *      $myList['name'] = $obj; 对应使用 \ArrayAccess.offsetSet($offset, $value)
 *      $obj = $myList['name']; 对应使用 \ArrayAccess.offsetGet($offset)
 *      isset($myList['name']); 对应使用 \ArrayAccess.offsetExists($offset)
 *      unset($myList['name']); 对应使用 \ArrayAccess.offsetUnset($offset)
 *
 *      \Countable 将提供对象的countable功能
 *      count($myList); 将对应使用 \Countable.count()
 *
 *      \IteratorAggregate 将提供对象支持 foreach 等的迭代操作
 *      foreach($myList as $key=>$value); 对应使用 \IteratorAggregate.getIterator(),返回必须可迭代
 *
 * Class ZList
 * @package Zf\Helper
 */
class ZList implements \Countable, \IteratorAggregate, \ArrayAccess
{
    /**
     * 属性判断和处理
     */
    use TProperty;

    /**
     * list的对象集合
     * @var array
     */
    private $_data = [];
    /**
     * 列表当前的统计数量
     * @var int
     */
    private $_count = 0;
    /**
     * list是否只读，默认可读写
     * @var bool
     */
    private $_readOnly = false;

    /**
     * 魔术方法：构造函数
     *
     * @param mixed $data
     * @param bool $readOnly
     *
     * @throws Exception
     * @throws ParameterException
     */
    public function __construct($data = null, $readOnly = false)
    {
        if (null !== $data) {
            $this->copyFrom($data);
        }
        $this->setReadOnly($readOnly);
    }

    /**
     * 从可迭代数据中复制成 list
     *
     * @param mixed $data
     *
     * @throws Exception
     * @throws ParameterException
     */
    public function copyFrom($data)
    {
        if (is_array($data) || ($data instanceof Traversable)) {
            if ($this->_count > 0) {
                $this->clear();
            }
            if ($data instanceof ZList) {
                $data = $data->_data;
            }
            foreach ($data as $item) {
                $this->push($item);
            }
        } elseif (null !== $data) {
            throw new ParameterException('实例化列表参数必须是数组或可遍历的对象', 1010002001);
        }
    }

    /**
     * 返回 list 是否只读
     *
     * @return bool
     */
    public function getReadOnly(): bool
    {
        return $this->_readOnly;
    }

    /**
     * 设置 list 是否只读
     *
     * @param bool $readOnly
     */
    public function setReadOnly(bool $readOnly)
    {
        $this->_readOnly = $readOnly;
    }

    /**
     * 返回元素在 list 中的索引
     *
     * @param mixed $item
     * @return int 未找到返回-1
     */
    protected function indexOf($item): int
    {
        if (false !== ($index = array_search($item, $this->_data, true))) {
            return $index;
        } else {
            return -1;
        }
    }

    /**
     * 在指定位置插入一个元素
     *
     * @param int $index
     * @param mixed $item
     *
     * @throws Exception
     */
    protected function insertAt(int $index, $item)
    {
        if ($this->getReadOnly()) {
            throw new Exception(replace('List({list})为只读，不允许执行插入操作', [
                'list' => get_class($this),
            ]), 1010002002);
        }

        if ($this->_count === $index) {
            $this->_data[$this->_count++] = $item;
        } elseif ($index >= 0 && $index < $this->_count) {
            array_splice($this->_data, $index, 0, [$item]);
            $this->_count++;
        } else {
            throw new Exception(replace('List({list})索引"{index}"已超出范围', [
                'list'  => get_class($this),
                'index' => $index,
            ]), 1010002003);
        }
    }

    /**
     * 删除一个 list 元素，并返回这个元素
     *
     * @param int $index
     * @return mixed
     *
     * @throws Exception
     */
    protected function removeAt(int $index)
    {
        if ($this->getReadOnly()) {
            throw new Exception(replace('List({list})为只读，不允许执行插入操作', [
                'list' => get_class($this),
            ]), 1010002004);
        }

        if ($index >= 0 && $index < $this->_count) {
            $this->_count--;
            if ($index === $this->_count) {
                return array_pop($this->_data);
            } else {
                $item = $this->_data[$index];
                array_splice($this->_data, $index, 1);
                return $item;
            }
        } else {
            throw new Exception(replace('List({list})索引"{index}"已超出范围', [
                'list'  => get_class($this),
                'index' => $index,
            ]), 1010002005);
        }
    }

    /**
     * 获取 list 中指定索引的元素
     *
     * @param int $index
     * @return mixed
     *
     * @throws Exception
     */
    protected function itemAt(int $index)
    {
        if (isset($this->_data[$index])) {
            return $this->_data[$index];
        } elseif ($index >= 0 && $index < $this->_count) {
            return $this->_data[$index];
        } else {
            throw new Exception(replace('List({list})索引"{index}"已超出范围', [
                'list'  => get_class($this),
                'index' => $index,
            ]), 1010002006);
        }
    }

    /**
     * list 合并
     *
     * @param mixed $data
     *
     * @throws Exception
     * @throws ParameterException
     */
    public function mergeWith($data)
    {
        if (is_array($data) || ($data instanceof Traversable)) {
            if ($data instanceof ZList) {
                $data = $data->_data;
            }
            foreach ($data as $item) {
                $this->push($item);
            }
        } elseif ($data !== null) {
            throw new ParameterException('列表合并参数必须是数组或可遍历的对象', 1010002007);
        }
    }

    /**
     * 获取 list 的长度
     *
     * @return int
     */
    public function getCount(): int
    {
        return $this->count();
    }

    /**
     * 判断是否包含元素
     *
     * @param mixed $item
     * @return bool
     */
    public function contains($item): bool
    {
        return $this->indexOf($item) >= 0;
    }

    /**
     * 列表尾部添加一个元素，并返回添加的元素索引
     *
     * @param mixed $item
     * @return int
     *
     * @throws Exception
     */
    public function push($item): int
    {
        $this->insertAt($this->_count, $item);
        return $this->_count - 1;
    }

    /**
     * 从列表尾部移除最后一个元素，并返回
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function pop()
    {
        return $this->removeAt($this->_count - 1);
    }

    /**
     * 向列表头添加一个元素，成功返回添加的元素索引
     *
     * @param mixed $item
     * @return int
     *
     * @throws Exception
     */
    public function unshift($item): int
    {
        $this->insertAt(0, $item);
        return 0;
    }

    /**
     * 移除列表的第一个元素，并返回
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function shift()
    {
        return $this->removeAt(0);
    }

    /**
     * 删除一个元素，返回元素在 list 中的索引，未找到返回 false
     *
     * @param mixed $item
     * @return bool|int
     *
     * @throws Exception
     */
    public function remove($item)
    {
        if (($index = $this->indexOf($item)) >= 0) {
            $this->removeAt($index);
            return $index;
        } else
            return false;
    }

    /**
     * 清除 list 的所有元素
     *
     * @throws Exception
     */
    public function clear()
    {
        for ($i = $this->_count - 1; $i >= 0; $i--) {
            $this->removeAt($i);
        }
    }

    /**
     * @inheritDoc   Countable
     * 调用 count($obj) 时被调用
     *
     * @return int
     * @since 5.1.0
     */
    public function count()
    {
        return $this->_count;
    }

    /**
     * @inheritDoc   IteratorAggregate
     * getIterator : 返回一个迭代器
     *
     * @return ListIterator
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new ListIterator($this->_data);
    }

    /**
     * @inheritDoc   ArrayAccess
     * isset($obj[{$offset}]) 时被调用
     *
     * @param mixed $offset
     * @return bool
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return ($offset >= 0 && $offset < $this->_count);
    }

    /**
     * @inheritDoc   ArrayAccess
     * $obj[{$offset}] 时被调用
     *
     * @param mixed $offset
     * @return mixed
     *
     * @throws Exception
     *
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->itemAt($offset);
    }

    /**
     * @inheritDoc   ArrayAccess
     * $obj[{$offset}] = $value 时被调用
     *
     * @param mixed $offset
     * @param mixed $value
     *
     * @throws Exception
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        if (null === $offset || $offset === $this->_count) {
            $this->insertAt($this->_count, $value);
        } else {
            $this->removeAt($offset);
            $this->insertAt($offset, $value);
        }
    }

    /**
     * @inheritDoc   ArrayAccess
     * unset($obj[{$offset}]) 时被调用
     *
     * @param mixed $offset
     *
     * @throws Exception
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        $this->removeAt($offset);
    }
}