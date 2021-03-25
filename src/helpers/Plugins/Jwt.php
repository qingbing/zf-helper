<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Plugins;


use Zf\Helper\Abstracts\Component;
use Zf\Helper\Exceptions\Exception;
use Zf\Helper\Exceptions\ParameterException;
use Zf\Helper\Plugins\Crypt\Openssl;
use Zf\Helper\ZMap;

/**
 * 无状态的web-json-token
 * Class Jwt
 * @package Zf\Helper\Plugins
 */
class Jwt extends Component
{
    const TYPE_ISSUED_BY      = 'iss';
    const TYPE_PERMITTED_FOR  = 'aud';
    const TYPE_ISSUED_AT      = 'iat';
    const TYPE_EXPIRES_AT     = 'exp';
    const TYPE_EXPIRES_BEFORE = 'nbf';
    const TYPE_IDENTIFIED_BY  = 'jti';

    /**
     * 默认设置的类型集合
     *
     * @return array
     */
    public static function types()
    {
        return [
            self::TYPE_ISSUED_BY      => "发布者",
            self::TYPE_PERMITTED_FOR  => "接受者",
            self::TYPE_ISSUED_AT      => "创建时间",
            self::TYPE_EXPIRES_AT     => "过期时间",
            self::TYPE_EXPIRES_BEFORE => "生效时间",
            self::TYPE_IDENTIFIED_BY  => "唯一标识",
        ];
    }

    const ERROR_NONE          = 0;
    const ERROR_INVALID_TOKEN = 1;
    const ERROR_EXPIRES_AT    = 2;
    const ERROR_AFTER_AT      = 3;
    const ERROR_OTHER         = 10;

    /**
     * 错误代码消息集合
     *
     * @return array
     */
    public static function errors()
    {
        return [
            self::ERROR_NONE          => '无误',
            self::ERROR_INVALID_TOKEN => '无效的TOKEN',
            self::ERROR_EXPIRES_AT    => 'TOKEN已过期',
            self::ERROR_AFTER_AT      => 'TOKEN还未到使用期',
        ];
    }

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
     * @var ICrypt
     */
    private $_crypt;
    /**
     * @var int token解析错误代码
     */
    private $_error = self::ERROR_NONE;
    /**
     * @var string 错误字段名
     */
    private $_errorKey;
    /**
     * @var ZMap 数据存储map
     */
    private $_map;

    /**
     * 获取token解析错误代码
     *
     * @return int
     */
    public function getError(): int
    {
        return $this->_error;
    }

    /**
     * 获取token解析错误内容
     *
     * @return string
     */
    public function getErrorMsg(): string
    {
        if (self::ERROR_OTHER === $this->_error) {
            return "{$this->_errorKey}匹配无效";
        }
        return self::errors()[$this->_error];
    }

    /**
     * 获取加密类
     *
     * @return Openssl
     */
    protected function getCrypt()
    {
        if (null === $this->_crypt) {
            $this->_crypt = Openssl::getInstance([
                'privateKey' => $this->privateKey,
                'publicKey'  => $this->publicKey,
                'passphrase' => $this->passphrase,
            ]);
        }
        return $this->_crypt;
    }

    /**
     * 获取map
     *
     * @param bool $new
     * @return ZMap
     * @throws Exception
     * @throws ParameterException
     */
    protected function getMap(bool $new = false): ZMap
    {
        if (null === $this->_map || true === $new) {
            $this->_map = new ZMap();
        }
        return $this->_map;
    }

    /**
     * 清空数据map
     *
     * @return $this
     * @throws Exception
     * @throws ParameterException
     */
    public function clearMap()
    {
        $this->getMap(true);
        $this->_error    = self::ERROR_NONE;
        $this->_errorKey = null;
        return $this;
    }

    /**
     * 添加一组键值对
     *
     * @param array $claims
     * @return $this
     * @throws Exception
     */
    public function addClaims(array $claims)
    {
        foreach ($claims as $name => $val) {
            $this->addClaim($name, $val);
        }
        return $this;
    }

    /**
     * 添加一个键值对
     *
     * @param string $name
     * @param mixed $val
     * @return $this
     * @throws Exception
     */
    public function addClaim(string $name, $val = null)
    {
        $this->getMap()->add($name, $val);
        return $this;
    }

    /**
     * 设置发布者
     *
     * @param string $val
     * @return $this
     * @throws Exception
     */
    public function issuedBy(string $val)
    {
        return $this->addClaim(self::TYPE_ISSUED_BY, $val);
    }

    /**
     * 设置接受者
     *
     * @param string $val
     * @return $this
     * @throws Exception
     */
    public function permittedFor(string $val)
    {
        return $this->addClaim(self::TYPE_PERMITTED_FOR, $val);
    }

    /**
     * 设置创建时间，时间戳
     *
     * @param int $val
     * @return $this
     * @throws Exception
     */
    public function issuedAt(int $val)
    {
        return $this->addClaim(self::TYPE_ISSUED_AT, $val);
    }

    /**
     * 设置过期时间，时间戳
     *
     * @param int $val
     * @return $this
     * @throws Exception
     */
    public function expiresAt(int $val)
    {
        return $this->addClaim(self::TYPE_EXPIRES_AT, $val);
    }

    /**
     * 设置生效时间，时间戳
     *
     * @param int $val
     * @return $this
     * @throws Exception
     */
    public function canOnlyBeUsedAfter(int $val)
    {
        return $this->addClaim(self::TYPE_EXPIRES_BEFORE, $val);
    }

    /**
     * 设置唯一标识
     *
     * @param mixed $val
     * @return $this
     * @throws Exception
     */
    public function identifiedBy($val)
    {
        return $this->addClaim(self::TYPE_IDENTIFIED_BY, $val);
    }

    /**
     * 获取数据token
     *
     * @return string
     * @throws Exception
     */
    public function getToken()
    {
        if (!$this->getMap()->contains(self::TYPE_ISSUED_AT)) {
            $this->issuedAt(time());
        }
        return $this->getCrypt()->encrypt($this->getMap()->getData());
    }

    /**
     * 校验token
     *
     * @param string $token
     * @param bool $needValid
     * @param array $validData
     * @return bool
     * @throws Exception
     * @throws ParameterException
     */
    public function verifyToken(string $token, bool $needValid = true, array $validData = []): bool
    {
        $data = $this->getCrypt()->decrypt($token);
        if (false === $data) {
            return $this->addError(self::ERROR_INVALID_TOKEN);
        }
        $map = $this->getMap(true);
        $map->copyFrom($data);
        $map->setReadOnly(true);
        if (true !== $needValid) {
            return true;
        }
        $nowTimestamp = time();
        // 过期时间
        $expireAt = $map->get(self::TYPE_EXPIRES_AT);
        if (null !== $expireAt && $expireAt < $nowTimestamp) {
            return $this->addError(self::ERROR_EXPIRES_AT, self::TYPE_EXPIRES_AT);
        }
        // 生效时间
        $beforeAt = $map->get(self::TYPE_EXPIRES_BEFORE);
        if (null !== $beforeAt && $beforeAt > $nowTimestamp) {
            return $this->addError(self::ERROR_AFTER_AT, self::TYPE_EXPIRES_BEFORE);
        }
        foreach ($validData as $key => $val) {
            if ($map->get($key) !== $val) {
                return $this->addError(self::ERROR_OTHER, $key);
            }
        }
        return true;
    }

    /**
     * 记录错误
     *
     * @param int $code
     * @param string|null $key
     * @return bool
     */
    protected function addError(int $code, ?string $key = null): bool
    {
        $this->_error    = $code;
        $this->_errorKey = $key;
        return false;
    }

    /**
     * 获取存储的数据
     *
     * @return array
     * @throws Exception
     */
    public function getClaims(): array
    {
        return $this->getMap()->getData();
    }

    /**
     * 获取一个指定的存储数据
     *
     * @param string $name
     * @return mixed
     * @throws Exception
     */
    public function getClaim(string $name)
    {
        return $this->getMap()->get($name);
    }

    /**
     * 获取发布者
     *
     * @return string|null
     * @throws Exception
     */
    public function getIssuedBy(): ?string
    {
        return $this->getClaim(self::TYPE_ISSUED_BY);
    }

    /**
     * 获取接受者
     *
     * @return string|null
     * @throws Exception
     */
    public function getPermittedFor(): ?string
    {
        return $this->getClaim(self::TYPE_PERMITTED_FOR);
    }

    /**
     * 获取创建时间，时间戳
     *
     * @return int|null
     * @throws Exception
     */
    public function getIssuedAt(): ?int
    {
        return $this->getClaim(self::TYPE_ISSUED_AT);
    }

    /**
     * 获取过期时间，时间戳
     *
     * @return int|null
     * @throws Exception
     */
    public function getExpiresAt(): ?int
    {
        return $this->getClaim(self::TYPE_EXPIRES_AT);
    }

    /**
     * 获取生效时间，时间戳
     *
     * @return int|null
     * @throws Exception
     */
    public function getCanOnlyBeUsedAfter(): ?int
    {
        return $this->getClaim(self::TYPE_EXPIRES_BEFORE);
    }

    /**
     * 获取唯一标识
     *
     * @return mixed
     * @throws Exception
     */
    public function getIdentifiedBy()
    {
        return $this->getClaim(self::TYPE_IDENTIFIED_BY);
    }
}
