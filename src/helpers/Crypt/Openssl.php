<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Crypt;


use Zf\Helper\Exceptions\Exception;
use Zf\Helper\Plugins\Crypt\Base64;

/**
 * openssl密码管理封装
 *
 * Class Openssl
 * @package Zf\Helper\Crypt
 */
class Openssl
{
    const PRICATE_KEY_BIT_512  = 512;
    const PRICATE_KEY_BIT_1024 = 1024;
    const PRICATE_KEY_BIT_2048 = 2048;
    const PRICATE_KEY_BIT_4096 = 4096;

    /**
     * 生成openssl的公私钥
     * @param string $passphrase
     * @param int $priKeyBits 字节数:512、1024、2048、4096...
     * @param int $priKeyType 加密类型
     * @param bool $longString
     * @return array
     * @throws Exception
     */
    public static function generateSecrets($passphrase = '', $priKeyBits = self::PRICATE_KEY_BIT_1024, $priKeyType = OPENSSL_KEYTYPE_RSA, bool $longString = false): array
    {
        $config = [
            "private_key_bits" => $priKeyBits,
            "private_key_type" => $priKeyType,
        ];
        $pkey   = openssl_pkey_new($config);
        if (false === $pkey) {
            throw new Exception("生成openssl密钥失败", 1010010001);
        }

        openssl_pkey_export($pkey, $privateKey, $passphrase);
        $public_key = openssl_pkey_get_details($pkey);
        $publicKey  = $public_key["key"];
        openssl_free_key($pkey);

        if ($longString) {
            $privateKey = self::getStringForPrivateKey($privateKey);
            $publicKey  = self::getStringForPublicKey($publicKey);
        }

        return [
            'pass'        => $passphrase,
            'private_key' => $privateKey,
            'public_key'  => $publicKey,
        ];
    }

    /**
     * 数据加密，为了兼容加密所有数据，数据在加密之前使用了 serialize
     *
     * @param string $publicKey
     * @param mixed $content 需要加密的数据
     * @param int $subLength 一次加密的字符串长度
     * @return string
     */
    public static function encrypt(string $publicKey, $content, $subLength = 117)
    {
        // 数据序列化
        $content = serialize($content);
        // 获取有效公钥
        $publicKey = self::getPublicKey($publicKey);
        // 获取公钥KEY
        $publicKey = openssl_get_publickey($publicKey);
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
     * @param string $privateKey
     * @param string $crypt 需要解密的数据
     * @param string $passphrase
     * @return mixed
     */
    public static function decrypt(string $privateKey, string $crypt, $passphrase = '')
    {
        // 获取有效私钥
        $privateKey = self::getPrivateKey($privateKey);
        // 获取私钥KEY
        $privateKey = openssl_get_privatekey($privateKey, $passphrase);
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

    /**
     * 判断是否是私钥
     *
     * @param string $privateKey
     * @return bool
     */
    protected static function isPrivateKey(string $privateKey)
    {
        return 0 === strpos($privateKey, "-----BEGIN ENCRYPTED PRIVATE KEY-----");
    }

    /**
     * 将私钥格式化成字符串
     *
     * @param string $privateKey
     * @return mixed|string
     */
    protected static function getStringForPrivateKey(string $privateKey)
    {
        if (!self::isPrivateKey($privateKey)) {
            return $privateKey;
        }
        return str_replace([
            '-----BEGIN ENCRYPTED PRIVATE KEY-----',
            '-----END ENCRYPTED PRIVATE KEY-----',
            "\n"
        ], '', $privateKey);
    }

    /**
     * 构造私钥
     *
     * @param string $privateKey
     * @return string
     */
    protected static function getPrivateKey(string $privateKey)
    {
        if (self::isPrivateKey($privateKey)) {
            return $privateKey;
        }
        $pa = str_split($privateKey, 64);
        array_unshift($pa, '-----BEGIN ENCRYPTED PRIVATE KEY-----');
        array_push($pa, '-----END ENCRYPTED PRIVATE KEY-----');
        return implode("\n", $pa);
    }

    /**
     * 判断是否是公钥
     *
     * @param string $publicKey
     * @return bool
     */
    protected static function isPublicKey(string $publicKey)
    {
        return 0 === strpos($publicKey, "-----BEGIN PUBLIC KEY-----");
    }

    /**
     * 将公钥格式化成字符串
     *
     * @param string $publicKey
     * @return mixed|string
     */
    protected static function getStringForPublicKey(string $publicKey)
    {
        if (!self::isPublicKey($publicKey)) {
            return $publicKey;
        }
        return str_replace([
            '-----BEGIN PUBLIC KEY-----',
            '-----END PUBLIC KEY-----',
            "\n"
        ], '', $publicKey);
    }

    /**
     * 构造公钥
     *
     * @param string $publicKey
     * @return string
     */
    protected static function getPublicKey(string $publicKey)
    {
        if (self::isPublicKey($publicKey)) {
            return $publicKey;
        }
        $pa = str_split($publicKey, 64);
        array_unshift($pa, '-----BEGIN PUBLIC KEY-----');
        array_push($pa, '-----END PUBLIC KEY-----');
        return implode("\n", $pa);
    }
}