<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Business;

use Zf\Helper\Abstracts\Factory;

/**
 * pid、id 的树形结构构建
 *
 * Class ParentTree
 * @package Zf\Helper\Business
 */
class ParentTree extends Factory
{
    /**
     * @var int 顶级数据标记
     */
    private $_top_tag = 0;
    /**
     * @var string 数据ID标识
     */
    private $_id = 'id';
    /**
     * @var string parentID数据标识
     */
    private $_pid = 'pid';
    /**
     * @var callable 数据过滤函数
     */
    private $_filter;
    /**
     * @var array 原始数据
     */
    private $_data = [];
    /**
     * @var array 树形结构数据
     */
    private $_treeData;

    /**
     * 数据顶级标识
     *
     * @param mixed $top_tag
     * @return $this
     */
    public function setTopTag($top_tag)
    {
        $this->_top_tag = $top_tag;
        return $this;
    }

    /**
     * 设置数据ID标识
     *
     * @param string $id
     * @return $this
     */
    public function setId(string $id)
    {
        $this->_id = $id;
        return $this;
    }

    /**
     * 设置parentID数据标识
     *
     * @param string $pid
     * @return $this
     */
    public function setPid(string $pid)
    {
        $this->_pid = $pid;
        return $this;
    }

    /**
     * 设置数据过滤函数
     *
     * @param callable|null $filter
     * @return $this
     */
    public function setFilter(?callable $filter)
    {
        $this->_filter = $filter;
        return $this;
    }

    /**
     * 设置原始数据
     *
     * @param array $data
     * @return $this
     */
    public function setData(array $data)
    {
        $this->_data = $data;
        return $this;
    }

    /**
     * 添加原始数据
     *
     * @param array $data
     * @return $this
     */
    public function addData(array $data)
    {
        $this->_data = array_merge($this->_data, $data);
        return $this;
    }

    /**
     * 获取树形结构数据
     *
     * @return array
     */
    public function getTreeData()
    {
        if (null === $this->_treeData) {
            $this->parse();
        }
        return $this->_treeData;
    }

    /**
     * 解析树形结构
     *
     * @return $this
     */
    public function parse()
    {
        if (is_callable($this->_filter)) {
            $this->_data = array_filter($this->_data, $this->_filter);
        }
        $this->_treeData = $this->_parse();
        return $this;
    }

    private function _parse($sign = '', $deep = 0)
    {
        $tree = array();
        $sign = ('' === $sign) ? $this->_top_tag : $sign;
        foreach ($this->_data as $k => $datum) {
            if ($datum[$this->_pid] != $sign) {
                continue;
            }
            unset($this->_data[$k]);
            array_push($tree, array('deep' => $deep, 'attr' => $datum, 'data' => $this->_parse($datum[$this->_id], $deep + 1)));
        }
        return $tree;
    }
}
