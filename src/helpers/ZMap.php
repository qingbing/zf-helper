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
use Zf\Helper\Iterators\MapIterator;
use Zf\Helper\Traits\TProperty;

/**
 * Map：提供add,get,remove,clear,count等操作
 *
 * Class ZMap
 * @package Zf\Helper
 *
 * @property array $data
 */
class ZMap implements \Countable, \IteratorAggregate, \ArrayAccess
{
    /**
     * 属性判断和处理
     */
    use TProperty;

    /**
     * map对象集合
     * @var array
     */
    private $_data = [];
    /**
     * map是否只读，默认可读写
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
        if ($data !== null) {
            $this->copyFrom($data);
        }
        $this->setReadOnly($readOnly);
    }

    /**
     * 返回 map 是否只读
     *
     * @return bool
     */
    public function getReadOnly(): bool
    {
        return $this->_readOnly;
    }

    /**
     * 设置 map 是否只读
     *
     * @param bool $readOnly
     */
    public function setReadOnly(bool $readOnly)
    {
        $this->_readOnly = $readOnly;
    }

    /**
     * 返回 map 中 key 对应的元素
     *
     * @param mixed $key
     * @return mixed|null
     */
    protected function itemAt($key)
    {
        if (isset($this->_data[$key])) {
            return $this->_data[$key];
        }
        return null;
    }

    /**
     * 从可迭代数据中复制成 map
     *
     * @param mixed $data
     *
     * @throws Exception
     * @throws ParameterException
     */
    public function copyFrom($data)
    {
        if (is_array($data) || $data instanceof Traversable) {
            if ($this->getCount() > 0) {
                $this->clear();
            }
            if ($data instanceof ZMap) {
                $data = $data->_data;
            }
            foreach ($data as $key => $value) {
                $this->add($key, $value);
            }
        } elseif ($data !== null) {
            throw new ParameterException('实例化列表参数必须是数组或可遍历的对象', 1010003001);
        }
    }

    /**
     * map 合并
     *
     * @param mixed $data
     * @param bool $recursive
     *
     * @throws Exception
     * @throws ParameterException
     */
    public function mergeWith($data, $recursive = true)
    {
        if (is_array($data) || $data instanceof Traversable) {
            if ($data instanceof ZMap) {
                $data = $data->_data;
            }
            if ($recursive) {
                if ($data instanceof Traversable) {
                    $d = [];
                    foreach ($data as $key => $value) {
                        $d[$key] = $value;
                    }
                    $this->_data = static::mergeArray($this->_data, $d);
                } else {
                    $this->_data = static::mergeArray($this->_data, $data);
                }
            } else {
                foreach ($data as $key => $value) {
                    $this->add($key, $value);
                }
            }
        } elseif (null !== $data) {
            throw new ParameterException('合并map参数必须是数组或可遍历的对象', 1010003002);
        }
    }

    /**
     * 合并数组
     *
     * @param mixed $a
     * @param mixed $b
     * @return array|mixed
     */
    public static function mergeArray($a, $b)
    {
        $args = func_get_args();
        $res  = array_shift($args);
        while (!empty($args)) {
            $next = array_shift($args);
            foreach ($next as $k => $v) {
                if (is_integer($k)) {
                    isset($res[$k]) ? $res[] = $v : $res[$k] = $v;
                } elseif (is_array($v) && isset($res[$k]) && is_array($res[$k])) {
                    $res[$k] = static::mergeArray($res[$k], $v);
                } else {
                    $res[$k] = $v;
                }
            }
        }
        return $res;
    }

    /**
     * 判断 map 中是否包含某个key
     *
     * @param mixed $key
     * @return bool
     */
    public function contains($key)
    {
        return isset($this->_data[$key]) || array_key_exists($key, $this->_data);
    }

    /**
     * 返回 map 的键集合
     *
     * @return array
     */
    public function getKeys(): array
    {
        return array_keys($this->_data);
    }

    /**
     * 为 map 添加一个元素
     *
     * @param mixed $key
     * @param mixed $value
     *
     * @throws Exception
     */
    public function add($key, $value)
    {
        if ($this->getReadOnly()) {
            throw new Exception('只读map，不允许执行添加操作', 1010003003);
        }
        if (null === $key) {
            $this->remove($key);
        } else {
            $this->_data[$key] = $value;
        }
    }

    /**
     * 返回 map 中 key 对应的元素
     *
     * @param mixed $key
     * @return mixed|null
     */
    public function get($key)
    {
        return $this->itemAt($key);
    }

    /**
     * 删除并返回一个 map 元素
     *
     * @param string $key
     * @return mixed|null
     *
     * @throws Exception
     */
    public function remove($key)
    {
        if ($this->getReadOnly()) {
            throw new Exception('只读map，不允许执行删除操作', 1010003004);
        }
        if (isset($this->_data[$key])) {
            $value = $this->_data[$key];
            unset($this->_data[$key]);
        } else {
            $value = null;
        }
        return $value;
    }

    /**
     * 清空 map 中的元素
     *
     * @throws Exception
     */
    public function clear()
    {
        foreach (array_keys($this->_data) as $key) {
            $this->remove($key);
        }
    }

    /**
     * 获取 map 的长度
     *
     * @return int
     */
    public function getCount(): int
    {
        return $this->count();
    }

    /**
     * @inheritDoc   Countable
     * 调用 count($obj) 时被调用，返回map的元素个数
     *
     * @return int
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->_data);
    }

    /**
     * @inheritDoc   IteratorAggregate
     * getIterator : 返回一个迭代器
     *
     * @return MapIterator
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new MapIterator($this->_data);
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
        return $this->contains($offset);
    }

    /**
     * @inheritDoc   ArrayAccess
     * $obj[{$offset}] 时被调用
     *
     * @param mixed $offset
     * @return mixed
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
        $this->add($offset, $value);
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
        $this->remove($offset);
    }

    /**
     * 获取全部数据
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->_data;
    }
}