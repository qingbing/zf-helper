<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Plugins;

/**
 * 密码管理类
 * Interface ICrypt
 * @package Zf\Helper\Plugins
 */
interface ICrypt
{
    /**
     * 数据加密
     *
     * @param mixed $content 需要加密的数据
     * @param int $subLength 一次加密的字符串长度
     * @return string
     */
    public function encrypt($content, $subLength);

    /**
     * 数据解密
     *
     * @param string $crypt 需要解密的数据
     * @return mixed
     */
    public function decrypt(string $crypt);
}