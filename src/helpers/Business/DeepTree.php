<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Business;

use Zf\Helper\Abstracts\TreeData;

/**
 * array-deep实现的 pid-id 树形结构构造
 *
 * Class DeepTree
 * @package Zf\Helper\Business
 */
class DeepTree extends TreeData
{
    /**
     * 解析数据成树形结构
     *
     * @return array
     */
    protected function parseSourceData(): array
    {
        return $this->_parse();
    }

    private function _parse($sign = '', $deep = 0)
    {
        $tree = array();
        $sign = ('' === $sign) ? $this->topTag : $sign;
        foreach ($this->sourceData as $k => $datum) {
            if ($datum[$this->pid] != $sign) {
                continue;
            }
            unset($this->sourceData[$k]);
            array_push($tree, array('deep' => $deep, 'attr' => $datum, 'data' => $this->_parse($datum[$this->id], $deep + 1)));
        }
        return $tree;
    }
}
