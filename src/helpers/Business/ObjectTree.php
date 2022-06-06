<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Business;


use Zf\Helper\Abstracts\TreeData;

/**
 * Object实现的 pid-id 树形结构构造
 *
 * Class ObjectTree
 * @package Zf\Helper\Business
 */
class ObjectTree extends TreeData
{
    private $_needEncodeData = true; // 数据源是否需要重新json_decode

    /**
     * 设置数据源是否需要重新object化
     *
     * @param bool $needEncodeData
     * @return $this
     */
    public function setNeedEncodeData(bool $needEncodeData = false)
    {
        $this->_needEncodeData = $needEncodeData;
        return $this;
    }

    /**
     * 解析数据成树形结构
     *
     * @return array
     */
    protected function parseSourceData(): array
    {
        if ($this->_needEncodeData) {
            $sourceData = json_decode(json_encode($this->sourceData));
        } else {
            $sourceData = $this->sourceData;
        }
        $sourceData = array_combine(array_column($sourceData, $this->id), $sourceData);
        foreach ($sourceData as $source) {
            if (!isset($sourceData[$source->{$this->pid}])) {
                continue;
            }
            if (!isset($sourceData[$source->{$this->pid}]->{$this->subDataName})) {
                $sourceData[$source->{$this->pid}]->{$this->subDataName} = [];
            }
            array_push($sourceData[$source->{$this->pid}]->{$this->subDataName}, $source);
        }
        foreach ($sourceData as $id => $source) {
            if ($source->{$this->pid} !== $this->topTag) {
                unset($sourceData[$id]);
            }
        }
        return array_values($sourceData);
    }

    /**
     * 转换成数组
     *
     * @param array $data
     * @return array
     */
    protected function toArrayData(array $data): array
    {
        $data = array_values($data);
        foreach ($data as &$datum) {
            if (isset($datum[$this->subDataName])) {
                $datum[$this->subDataName] = $this->toArrayData($datum[$this->subDataName]);
            }
        }
        unset($datum);
        return $data;
    }
}