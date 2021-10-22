<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Debug;

use Zf\Helper\Business\Region;
use Zf\Helper\Identity\IdentityParser;

/**
 * 辅助类 : 辅助生成器
 *
 * Class Generator
 * @package Zf\Helper\Debug
 */
class Generator
{
    /**
     * 根据提供的 区划代码、生日、性别 生成随机身份证号
     *      0～6 : 行政区划代码
     *      7～14 : 生日
     *      15～17 : 顺序码，也是性别码，偶数为男，奇数为女
     *      18 : 校验码
     * @param string $areaCode
     * @param string $birthday
     * @param int $sex
     * @return string
     */
    public static function IdCard($areaCode, $birthday, $sex = IdentityParser::GENDER_FEMALE): string
    {
        if ($sex == IdentityParser::GENDER_FEMALE) {
            $num = sprintf("%03d", rand(0, 499) * 2 + 1);
        } else {
            $num = sprintf("%03d", rand(0, 499) * 2);
        }
        $idNo = "{$areaCode}{$birthday}{$num}";
        return $idNo . IdentityParser::getVerifyCode($idNo);
    }

    /**
     * 在时间区间范围内随机生成身份证号
     *
     * @param string $minDate
     * @param string $maxDate
     * @return string
     */
    public static function randIdCard($minDate = '1949-10-01', $maxDate = '2021-01-01')
    {
        $region   = array_keys(Region::getInstance()->getAllTowns());
        $areaCode = $region[rand(0, count($region) - 1)];
        $birthday = date("Ymd", rand(strtotime($minDate), strtotime($maxDate)));
        $sex      = rand(0, 1);
        return self::IdCard($areaCode, $birthday, $sex);
    }
}