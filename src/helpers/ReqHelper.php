<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper;

/**
 * 请求帮助类
 *
 * Class ReqHelper
 * @package Zf\Helper
 */
class ReqHelper
{
    /**
     * 请求 LOG-ID
     * @var string
     */
    private static $_traceId;

    /**
     * 获取当前的请求的 LOG-ID
     * @return string
     */
    public static function getTraceId(): string
    {
        if (!self::$_traceId) {
            if (isset($_SERVER['HTTP_ZF_TRACE_ID'])) {
                $traceId = $_SERVER['HTTP_ZF_TRACE_ID'];
            } else if (isset($_REQUEST['ZF_TRACE_ID'])) {
                $traceId = $_REQUEST['ZF_TRACE_ID'];
            } else {
                $traceId = Id::uniqid();
            }
            self::$_traceId = $traceId;
        }
        return self::$_traceId;
    }

    /**
     * 判断是否是在cli模式下运行
     *
     * @return bool
     */
    public static function isCli(): bool
    {
        return PHP_SAPI === 'cli';
    }

    /**
     * 获取 accept-types,发送端希望接受的数据类型，比如：text/xml
     *
     * @return null|string
     */
    public static function acceptTypes()
    {
        return isset($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT'] : null;
    }

    /**
     * 返回链接的请求类型，可以设置在POST请求里面，主要为了满足 RESTfull 请求
     *      类型有：GET, POST, HEAD, PUT, PATCH, DELETE
     *
     * @return string
     */
    public static function requestMethod(): string
    {
        if (isset($_POST['_method'])) {
            return strtoupper($_POST['_method']);
        } elseif (isset($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'])) {
            return strtoupper($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE']);
        }

        return strtoupper(isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET');
    }

    /**
     * 获取请求的Uri
     *
     * @return string
     */
    public static function requestUri(): string
    {
        return isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
    }

    /**
     * 获取请求的"query"部分（? 后面内容）
     *
     * @return string
     */
    public static function queryString(): string
    {
        return isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';
    }

    /**
     * 判断请求是否是 ajax
     *
     * @return bool
     */
    public static function isAjaxRequest(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    /**
     * 返回访问链接是否为安全链接(https)
     *
     * @return bool
     */
    public static function isSecureConnection(): bool
    {
        return isset($_SERVER['HTTPS']) && !strcasecmp($_SERVER['HTTPS'], 'on');
    }

    /**
     * 获取 http 访问端口
     *
     * @return string
     */
    public static function serverPort()
    {
        return $_SERVER['SERVER_PORT'];
    }

    /**
     * 返回主机名
     *
     * @return string
     */
    public static function host(): string
    {
        return isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
    }

    /**
     * 获取用户IP地址
     *
     * @return string
     */
    public static function userHostAddress(): string
    {
        return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1';
    }

    /**
     * 获取 URL 来源
     *
     * @return null|string
     */
    public static function urlReferrer()
    {
        return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
    }

    /**
     * 获取用户访问客户端信息
     *
     * @return null|string
     */
    public static function userAgent()
    {
        return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null;
    }

    /**
     * 获取普通访问链接的端口
     *
     * @return int
     */
    public static function getPort()
    {
        return !self::isSecureConnection() && isset($_SERVER['SERVER_PORT']) ? (int)$_SERVER['SERVER_PORT'] : 80;
    }

    /**
     * 获取安全链接（https）的端口
     *
     * @return int
     */
    public static function getSecurePort()
    {
        return self::isSecureConnection() && isset($_SERVER['SERVER_PORT']) ? (int)$_SERVER['SERVER_PORT'] : 443;
    }
}