<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Abstracts;


/**
 * 数组转换为树形结构基类
 *
 * Class TreeData
 * @package Zf\Helper\Abstracts
 */
abstract class TreeData extends Factory
{
    protected $topTag     = 0; // 顶级数据标记
    protected $id         = 'id'; // 数据ID标识
    protected $pid        = 'pid'; // parentID数据标识
    protected $sourceData = []; // 原始数据
    private   $_treeData;
    /**
     * @var callable 数据过滤函数
     */
    protected $filter;

    /**
     * 设置数据顶级标识
     *
     * @param mixed $topTag
     * @return $this
     */
    public function setTopTag($topTag)
    {
        $this->topTag = $topTag;
        return $this;
    }

    /**
     * 设置数据ID标识
     *
     * @param mixed $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * 设置parentID数据标识
     *
     * @param mixed $pid
     * @return $this
     */
    public function setPid($pid)
    {
        $this->pid = $pid;
        return $this;
    }

    /**
     * 设置原始数据
     *
     * @param array $data
     * @return $this
     */
    public function setSourceData(array $data)
    {
        $this->sourceData = $data;
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
        $this->filter = $filter;
        return $this;
    }

    /**
     * 返回树形化的接口数据
     *
     * @return array
     */
    public function getTreeData()
    {
        if (null === $this->_treeData) {
            if (is_callable($this->filter)) {
                $this->sourceData = array_filter($this->sourceData, $this->filter);
            }
            $this->_treeData = $this->parseSourceData();
        }
        return $this->_treeData;
    }

    /**
     * 解析数据成树形结构
     *
     * @return array
     */
    abstract protected function parseSourceData(): array;
}