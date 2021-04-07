<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Plugins\Crypt;

use Zf\Helper\Abstracts\Component;
use Zf\Helper\Plugins\ICrypt;

/**
 * Openssl 加密和解密封装
 *
 * Class Openssl
 * @package Zf\Helper\Crypt
 */
class Openssl extends Component implements ICrypt
{
    /**
     * @var string openssl 公钥
     */
    public $publicKey;
    /**
     * @var string openssl 私钥
     */
    public $privateKey;
    /**
     * @var string 私钥密码
     */
    public $passphrase;

    /**
     * 数据加密，为了兼容加密所有数据，数据在加密之前使用了 serialize
     *
     * @param mixed $content 需要加密的数据
     * @param int $subLength 一次加密的字符串长度
     * @return string
     */
    public function encrypt($content, $subLength = 117)
    {
        return \Zf\Helper\Crypt\Openssl::encrypt($this->publicKey, $content, $subLength);
    }

    /**
     * 数据解密
     *
     * @param string $crypt 需要解密的数据
     * @return mixed
     */
    public function decrypt(string $crypt)
    {
        return \Zf\Helper\Crypt\Openssl::decrypt($this->privateKey, $crypt, $this->passphrase);
    }
}