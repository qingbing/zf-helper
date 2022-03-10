<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

if (!function_exists('is_url')) {
    /**
     * 判断一个变量是否是真是的URL
     *
     * @param string|null $var
     * @return bool
     */
    function is_url(?string $var): bool
    {
        if (null == $var) {
            return false;
        }
        $pattern = '/^(?:(?:http|ftp|file)s?):\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)(?::\d{1,5})?(?:$|[?\/#])/iu';
        return preg_match($pattern, $var) > 0;
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
        if (is_array($var)) {
            return true;
        }
        json_decode($var);
        return 0 === json_last_error();
    }
}

if (!function_exists('is_datetime')) {
    /**
     * 判断一个变量是否是有效的日期格式
     *
     * @param string $var
     * @param string $delimiter
     * @return bool
     */
    function is_datetime(string $var, $delimiter = '-')
    {
        $pattern = '/^(\d{2})?\d{2}{delimiter}[0|1]?\d{delimiter}[0-3]?\d( [0-2]?\d:[0-5]?\d:[0-5]?\d)?$/';
        $pattern = replace($pattern, ['delimiter' => $delimiter]);
        return 1 === preg_match($pattern, $var);
    }
}

if (!function_exists('is_real_array')) {
    function is_real_array($var)
    {
        /**
         * 判断是否是真实的数字数组，数组索引为0,1,2...
         */
        if (!is_array($var)) {
            return false;
        }
        return array_keys($var) === array_keys(array_fill(0, count($var), ''));
    }
}

if (!function_exists('define_var')) {
    /**
     * 获取常量值
     *
     * @param string $constantName
     * @param null $default
     * @return mixed|null
     */
    function define_var(string $constantName, $default = null)
    {
        return defined($constantName) ? constant($constantName) : $default;
    }
}

if (!function_exists('replace')) {
    /**
     * 信息模版替换
     *
     * @param string $message
     * @param array $context
     * @param bool $withQuote
     * @return string
     */
    function replace(string $message, array $context = [], bool $withQuote = true)
    {
        $replace = [];
        if (!$withQuote) {
            foreach ($context as $key => $val) {
                if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                    $replace['{' . $key . '}'] = $val;
                }
            }
        } else {
            $replace = $context;
        }
        return strtr($message, $replace);
    }
}

if (!function_exists('trim_data')) {
    /**
     * 对数据递归使用 trim 函数
     *
     * @param mixed $data
     * @param string $charlist
     * @return array|string|mixed
     */
    function trim_data($data, $charlist = " \t\n\r\0\x0B")
    {
        if (is_object($data)) {
            foreach ($data as $property => $datum) {
                $data->{$property} = trim_data($datum, $charlist);
            }
            return $data;
        } elseif (is_array($data)) {
            foreach ($data as $k => $datum) {
                $data[$k] = trim_data($datum, $charlist);
            }
            return $data;
        } else {
            return trim($data, $charlist);
        }
    }
}

if (!function_exists('explode_data')) {
    /**
     * 对数据进行 explode 处理，需要去掉空数据和数据左右空字符
     *
     * @param $string
     * @param string $delimiter
     * @param bool $unique
     * @return array
     */
    function explode_data($string, string $delimiter = ',', bool $unique = true)
    {
        if (is_array($string)) {
            return $unique ? array_unique($string) : $string;
        }
        if ('' === $delimiter || null === $delimiter || !is_string($string)) {
            return (array)$string;
        }
        $string = trim($string, " \t\n\r\0\x0B" . $delimiter);
        $R      = [];
        foreach (explode($delimiter, $string) as $value) {
            if ("" === ($value = trim($value))) {
                continue;
            }
            array_push($R, $value);
        }
        return $unique ? array_unique($R) : $R;
    }
}

if (!function_exists('release_json')) {
    /**
     * 将数据(json)字符串或对象转换成数字，字符串，数组等数据
     *
     * @param mixed $var
     * @return mixed
     */
    function release_json($var)
    {
        if (is_string($var)) {
            return json_decode($var, true);
        } else {
            return json_decode(json_encode($var), true);
        }
    }
}