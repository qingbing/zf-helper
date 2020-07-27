<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Zf\Helper\Abstracts\Component;
use Zf\Helper\Exceptions\Exception;

/**
 * Jwt 封装
 *
 * Class JwtHelper
 * @package Zf\Helper
 */
class JwtHelper extends Component
{
    /**
     * @var string 公钥
     */
    public $publicKey;
    /**
     * @var string 私钥
     */
    public $privateKey;
    /**
     * @var string 钥匙密码
     */
    public $passphrase = null;
    /**
     * @var string 生成signature的算法
     */
    public $alg = 'HS256';
    /**
     * @var string 类型
     */
    public $typ = 'JWT';

    /**
     * 生成 jwt token
     *
     * [
     * "iss"       => 'backend',                 发布者
     * "aud"       => 'SMALL',                   接收方
     * "iat"       => time(),                    创建时间
     * "nbf"       => time(),                    此时间后可用
     * 'exp'       => strtotime('30 days'),      过期时间
     * 'jti'       => 1,                         jwt 唯一标识
     * 'id'        => $uid,                      操作者 uid  自定义字段
     * ]
     *
     * @param array $payload
     * @param bool $toString
     * @return \Lcobucci\JWT\Token|string
     */
    public function getToken(array $payload, $toString = true)
    {
        $builder = new Builder();
        $header  = [
            'typ' => $this->typ,
            'alg' => $this->alg,
        ];
        foreach ($header as $name => $value) {
            $builder->withHeader($name, $value);
        }

        foreach ($payload as $key => $val) {
            switch ($key) {
                case 'iss': // 发布者
                    $builder->issuedBy($val);
                    break;
                case 'aud': // 接收者
                    $builder->permittedFor($val);
                    break;
                case 'iat': // token 创建时间
                    $builder->issuedAt($val);
                    break;
                case 'nbf': // 此时间后可用
                    $builder->canOnlyBeUsedAfter($val);
                    break;
                case 'exp': // 过期时间，时间戳
                    $builder->expiresAt($val);
                    break;
                case 'jti': // jwt 唯一标识
                    $builder->identifiedBy($val);
                    break;
                default: // 自定义参数
                    $builder->withClaim($key, $val);
                    break;
            }
        }

        $token = $builder->getToken(new Sha256(), new Key($this->privateKey, $this->passphrase));
        if ($toString) {
            return (string)$token;
        } else {
            return $token;
        }
    }

    /**
     * 验证token是否有效,默认验证exp,nbf,iat时间
     *
     * @param string $token
     * @return \Lcobucci\JWT\Token
     * @throws Exception
     */
    public function verifyToken(string $token)
    {
        $parser = (new Parser())->parse($token);
        if (!$parser->verify(new Sha256(), $this->publicKey)) {
            throw new Exception('无效的token', 1010008001);
        }
        if ($parser->isExpired()) {
            throw new Exception('token 已过期', 1010008002);
        }
        return $parser;
    }
}