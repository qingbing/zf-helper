<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Identity;


use Zf\Helper\Abstracts\Factory;
use Zf\Helper\Exceptions\ParameterException;
use Zf\Helper\FileHelper;
use Zf\Helper\Format;

/**
 * 身份证号解析
 *
 * Class IdentityParser
 * @package Zf\Helper\Identity
 *
 * @property $invalidType int 无效代码
 * @property $invalidMessage string 无效消息
 * @property $birthday string 出生日期
 * @property $fullIdCardNo string 18位身份证号
 * @property $age int 年龄
 * @property $gender int 性别
 * @property $region array 行政区
 */
class IdentityParser extends Factory
{
    const INVALID_TYPE_NONE     = 0; // 正常
    const INVALID_TYPE_FORMAT   = 1; // 生份证号格式不正确
    const INVALID_TYPE_REGION   = 2; // 省份区域代码无效
    const INVALID_TYPE_BIRTHDAY = 3; // 出生日期无效
    const INVALID_TYPE_VERIFY   = 4; // 身份证校验码无效

    const GENDER_MALE   = 1;
    const GENDER_FEMALE = 0;

    /**
     * 身份证异常信息
     *
     * @return array
     */
    public static function invalidTypes()
    {
        return [
            self::INVALID_TYPE_NONE     => "正常",
            self::INVALID_TYPE_FORMAT   => "生份证号格式不正确",
            self::INVALID_TYPE_REGION   => "省份区域代码无效",
            self::INVALID_TYPE_BIRTHDAY => "出生日期无效",
            self::INVALID_TYPE_VERIFY   => "身份证校验码无效",
        ];
    }

    /**
     * 性别集合
     *
     * @return array
     */
    public static function genders()
    {
        return [
            self::GENDER_MALE   => '男',
            self::GENDER_FEMALE => '女',
        ];
    }

    /**
     * @var array 加权因子
     */
    protected $factors = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];
    /**
     * @var array 校验码
     */
    protected $verifyCodes = ['1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2'];
    /**
     * @var array 区域列表
     */
    protected $regions; // 区域列表

    private $_idCardNo; // 身份证号
    private $_fullIdCard; // 18位身份证号
    private $_invalidType; // 身份证无效类型

    /**
     * 构造函数后执行，子类可以覆盖
     */
    protected function init()
    {
        $this->regions = json_decode(FileHelper::getContent(__DIR__ . '/data/region.json'), true);
    }

    /*
     * 实例设置身份证号码
     *
     * @param string $idCardNo
     * @return $this
     */
    public function setIdCard(string $idCardNo)
    {
        $this->_idCardNo    = $idCardNo;
        $this->_fullIdCard  = null;
        $this->_invalidType = null;
        return $this;
    }

    /**
     * 校验是身份证号是否有效
     *
     * @return bool
     */
    public function isValid(): bool
    {
        // 已经验证过返回验证结果即可
        if (null !== $this->_invalidType) {
            return self::INVALID_TYPE_NONE === $this->_invalidType;
        }
        // 验证格式：17位数字+[xX\D] 或者 15位数字
        if (false === preg_match("/^([\d]{17}[xX\d]|[\d]{15})$/", $this->_idCardNo)) {
            $this->_invalidType = self::INVALID_TYPE_FORMAT;
            return false;
        }

        // 取前2位后尾0补足6位
        $provinceRegionCode = str_pad(substr($this->_idCardNo, 0, 2), 6, '0', STR_PAD_RIGHT);
        if (!isset($this->regions[$provinceRegionCode])) {
            $this->_invalidType = self::INVALID_TYPE_REGION;
            return false;
        }

        // 验证生日是否有效
        $len = strlen($this->_idCardNo);
        if (18 === $len) {
            $year  = substr($this->_idCardNo, 6, 4);
            $month = substr($this->_idCardNo, 10, 2);
            $day   = substr($this->_idCardNo, 12, 2);
        } else {
            $year  = '19' . substr($this->_idCardNo, 6, 2);
            $month = substr($this->_idCardNo, 8, 2);
            $day   = substr($this->_idCardNo, 10, 2);
        }
        if (false === checkdate($month, $day, $year)) {
            $this->_invalidType = self::INVALID_TYPE_BIRTHDAY;
            return false;
        }

        // 验证校验码是否有效
        if (18 === $len) {
            $baseCode   = substr($this->_idCardNo, 0, 17);
            $verifyCode = substr($this->_idCardNo, 17, 1);
            $total      = 0;
            for ($i = 0; $i < 17; $i++) {
                $total += $baseCode{$i} * $this->factors[$i];
            }
            $mod = $total % 11;
            if ($this->verifyCodes[$mod] != $verifyCode) {
                $this->_invalidType = self::INVALID_TYPE_VERIFY;
                return false;
            }
        }
        return true;
    }

    /**
     * 无效代码
     *
     * @return int
     */
    public function getInvalidType(): int
    {
        return $this->_invalidType;
    }

    /**
     * 返回无效消息
     *
     * @return string
     */
    public function getInvalidMessage(): string
    {
        return self::invalidTypes()[$this->_invalidType];
    }

    /**
     * 验证是否合法身份证，不合法跑出异常
     *
     * @throws ParameterException
     */
    public function invalidThrow()
    {
        if (!$this->isValid()) {
            throw new ParameterException(self::invalidTypes()[$this->_invalidType], 1010009001);
        }
    }

    /**
     * 获取18位身份证号码.
     *
     * @return string
     */
    public function getFullIdCardNo(): string
    {
        if (null === $this->_fullIdCard) {
            if (15 === strlen($this->_idCardNo)) {
                // 不全出生年
                $fullIdCard = substr_replace($this->_idCardNo, '19', 6, 0);
                // 计算校验码
                $total = 0;
                for ($i = 0; $i < 17; $i++) {
                    $total += $fullIdCard{$i} * $this->factors[$i];
                }
                $fullIdCard .= $this->verifyCodes[$total % 11];
            } else {
                $fullIdCard = $this->_idCardNo;
            }
            $this->_fullIdCard = $fullIdCard;
        }
        return $this->_fullIdCard;
    }

    /**
     * 获取出生日期
     *
     * @param string $format
     * @return string
     * @throws ParameterException
     */
    public function getBirthday($format = 'Y-m-d'): string
    {
        // 校验身份证号
        $this->invalidThrow();
        // 补18位全身份证号
        $idCard = $this->getFullIdCardNo();
        // 返回出生日期
        return Format::date(strtotime(substr($idCard, 6, 8)), $format);
    }

    /**
     * 获取周岁年龄
     *
     * @param mixed $now 相对时间点, 默认为当前时间
     * @return int
     */
    public function getAge($now = null): int
    {
        // 获取18位身份证号
        $fullIdCardNo = $this->getFullIdCardNo();
        // 计算身份证上的年月日
        $birthdayYear  = substr($fullIdCardNo, 6, 4);
        $birthdayMonth = substr($fullIdCardNo, 10, 2);
        $birthdayDay   = substr($fullIdCardNo, 12, 2);
        // 计算对比时间的年月日
        if (null === $now) {
            $relativeTimestamp = time();
        } else {
            $relativeTimestamp = strtotime($now);
        }
        $relativeYear  = date("Y", $relativeTimestamp);
        $relativeMonth = date("m", $relativeTimestamp);
        $relativeDay   = date("d", $relativeTimestamp);

        $birth    = "{$birthdayYear}{$birthdayMonth}{$birthdayDay}";
        $relative = "{$relativeYear}{$relativeMonth}{$relativeDay}";
        // 尚未出生，不计算年龄
        if ($birth > $relative) {
            return -1;
        }

        // 通过年月计算年龄
        $diffYear = $relativeYear - $birthdayYear;
        if ($relativeMonth > $birthdayMonth) {
            $age = $diffYear;
        } else if ($relativeMonth < $birthdayMonth) {
            $age = $diffYear - 1;
        } else if ($relativeDay < $birthdayDay) {
            $age = $diffYear - 1;
        } else {
            $age = $diffYear;
        }
        return $age;
    }

    /**
     * 获取性别:0->男,1->女
     *
     * @return int
     */
    public function getGender(): int
    {
        // 获取18位身份证号
        $fullIdCardNo = $this->getFullIdCardNo();
        $gender       = substr($fullIdCardNo, 16, 1);
        return $gender % 2 == 0 ? self::GENDER_FEMALE : self::GENDER_MALE;
    }

    /**
     * 获取区域信息
     * @return array
     * [
     *      'province'  => '',  // 省（自治区、直辖市、特别行政区）
     *      'city'      => '',  // 市（地级市、自治州、盟及国家直辖市所属市辖区和县）
     *      'district'  => '',  // 县（市辖区、县级市、旗）
     * ]
     */
    public function getRegion()
    {
        // 获取18位身份证号
        $fullIdCardNo = $this->getFullIdCardNo();
        // 获取 省、市、区 行政代码
        $provinceCode = substr($fullIdCardNo, 0, 2) . '0000';
        $cityCode     = substr($fullIdCardNo, 0, 4) . '00';
        $districtCode = substr($fullIdCardNo, 0, 6);
        // 返回行政区
        return [
            'province' => $this->regions[$provinceCode],
            'city'     => $this->regions[$cityCode] ?? null,
            'district' => $this->regions[$districtCode] ?? null,
        ];
    }
}