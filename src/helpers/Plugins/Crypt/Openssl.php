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
        // json_encode
        $content = serialize($content);
        // 获取公钥KEY
        $publicKey = openssl_get_publickey($this->publicKey);
        // 对数据分片加密：对于open_public_encrypt 函数最大支持加密的长度为117，超过将返回空字符
        $cryptStr = "";
        $ca       = str_split($content, $subLength);
        foreach ($ca as $c) {
            openssl_public_encrypt($c, $tCryptStr, $publicKey);//公钥加密
            $cryptStr .= $tCryptStr;
        }
        // 对数据进行 base64 编码
        $cryptStr = Base64::encrypt($cryptStr);
        // 销毁公钥KEY
        openssl_free_key($publicKey);
        return $cryptStr;
    }

    /**
     * 数据解密
     *
     * @param string $crypt 需要解密的数据
     * @return mixed
     */
    public function decrypt(string $crypt)
    {
        // 获取私钥KEY
        $privateKey = openssl_get_privatekey($this->privateKey, $this->passphrase);
        $cryptStr   = "";
        // 将加密数据 base64 解码后128长度分片：openssl_public_encrypt 加密串的长度
        $ca = str_split(Base64::decrypt($crypt), 128);
        foreach ($ca as $c) {
            openssl_private_decrypt($c, $tCryptStr, $privateKey);//私钥解密
            $cryptStr .= $tCryptStr;
        }
        // 销毁私钥KEY
        openssl_free_key($privateKey);
        return unserialize($cryptStr);
    }
}