<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

if (!function_exists('interpolate')) {
    /**
     * 信息模版替换
     *
     * @param string $message
     * @param array $context
     * @param bool $withQuote
     * @return string
     */
    function interpolate(string $message, array $context = [], bool $withQuote = false)
    {
        $replace = [];
        if (!$withQuote) {
            foreach ($context as $key => $val) {
                if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                    $replace['{' . $key . '}'] = $val;
                }
            }
        }
        return strtr($message, $replace);
    }
}

if (!function_exists('is_json')) {
    /**
     * 判断一个变量可否json化
     *
     * @param mixed $var
     * @return bool
     */
    function is_json($var)
    {
        json_decode($var);
        return 0 === json_last_error();
    }
}