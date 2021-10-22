<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Business;


use Zf\Helper\Abstracts\Singleton;
use Zf\Helper\Exceptions\BusinessException;
use Zf\Helper\FileHelper;

/**
 * Class Region
 * @package Zf\Helper\Business
 *
 * @link http://www.mca.gov.cn/article/sj/xzqh/2020/20201201.html
 */
class Region extends Singleton
{
    /**
     * @var array 行政区划表
     */
    protected $regions;

    /**
     * @inheritDoc
     */
    protected function init()
    {
        $this->regions = json_decode(FileHelper::getContent(__DIR__ . '/region/data.json'), true);
    }

    /**
     * 解析代码成省市区及代码
     *
     * @param string $code
     * @return array
     * @throws BusinessException
     */
    public function releaseCode(string $code): array
    {
        // 代码分解
        $codes = $this->releaseToCode($code);
        // 赋值默认值
        $codes['province_name'] = $this->regions[$codes['province_code']];
        $codes['city_name']     = '';
        $codes['town_name']     = '';
        // 赋值市
        if (!empty($codes['city_code'])) {
            $codes['city_name'] = $this->regions[$codes['city_code']];
        }
        // 赋值区
        if (!empty($codes['town_code'])) {
            $codes['town_name'] = $this->regions[$codes['town_code']];
        }
        return $codes;
    }

    /**
     * 分解地区代码
     *
     * @param string $code
     * @return array
     * @throws BusinessException
     */
    protected function releaseToCode(string $code): array
    {
        if (!isset($this->regions[$code])) {
            throw new BusinessException("不存在的地址代码");
        }
        $code = rtrim($code, '0');
        if (0 !== strlen($code) % 2) {
            $code .= "0";
        }
        $ta       = str_split($code, 2);
        $pCode    = array_shift($ta);
        $cCode    = $pCode . array_shift($ta);
        $townCode = $cCode . array_shift($ta);

        $provinceCode = "{$pCode}0000";
        $cityCode     = 4 === strlen($cCode) ? "{$cCode}00" : '';
        $townCode     = 6 === strlen($townCode) ? $townCode : '';
        return [
            'province_code' => $provinceCode,
            'city_code'     => $cityCode,
            'town_code'     => $townCode,
        ];
    }

    /**
     * 获取代码的子区域
     *
     * @param string $code
     * @return array
     * @throws BusinessException
     */
    public function getChildren(string $code): array
    {
        $code = rtrim($code, '0');
        if (0 !== strlen($code) % 2) {
            $code .= "0";
        }
        switch (strlen($code)) {
            case 0:
                // 返回所有身份
                $minCode = 0;
                $maxCode = "999999";
                return array_filter($this->regions, function ($code) use ($minCode, $maxCode) {
                    if ($code <= $minCode || $code >= $maxCode) {
                        return false;
                    }
                    return strlen(rtrim($code, '0')) <= 2;
                }, ARRAY_FILTER_USE_KEY);
            case 2:
                // 返回所有市区
                $minCode = "{$code}0000";
                $maxCode = "{$code}9999";
                return array_filter($this->regions, function ($code) use ($minCode, $maxCode) {
                    if ($code <= $minCode || $code >= $maxCode) {
                        return false;
                    }
                    return strlen(rtrim($code, '0')) <= 4;
                }, ARRAY_FILTER_USE_KEY);
                break;
            case 4:
                // 返回所有城镇
                $minCode = "{$code}00";
                $maxCode = "{$code}99";
                return array_filter($this->regions, function ($code) use ($minCode, $maxCode) {
                    return $code > $minCode && $code < $maxCode;
                }, ARRAY_FILTER_USE_KEY);
                break;
            default:
                throw new BusinessException("不存在子区域");
        }
    }

    /**
     * 返回所有城镇
     *
     * @return array
     */
    public function getAllTowns()
    {
        return array_filter($this->regions, function ($code) {
            return strlen(rtrim($code, '0')) === 6;
        }, ARRAY_FILTER_USE_KEY);
    }
}