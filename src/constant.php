<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */
/**
 * 常规常量定义
 */
// 性别
defined('SEX_UNKNOWN') or define('SEX_UNKNOWN', "U");
defined('SEX_MALE') or define('SEX_MALE', "M");
defined('SEX_FEMALE') or define('SEX_FEMALE', "F");
// 是否选择
defined('IS_NO') or define('IS_NO', 0);
defined('IS_YES') or define('IS_YES', 1);
// 禁用状态
defined('IS_FORBIDDEN_NO') or define('IS_FORBIDDEN_NO', 0);
defined('IS_FORBIDDEN_YES') or define('IS_FORBIDDEN_YES', 1);
// 开启状态
defined('IS_ENABLE_NO') or define('IS_ENABLE_NO', 0);
defined('IS_ENABLE_YES') or define('IS_ENABLE_YES', 1);
// 删除状态
defined('IS_DELETED_NO') or define('IS_DELETED_NO', 0);
defined('IS_DELETED_YES') or define('IS_DELETED_YES', 1);

// 前后标识
defined("PREV") or define("PREV", "prev"); // 前
defined("NEXT") or define("NEXT", "next"); // 后

// 时间空标识
defined("EMPTY_TIME_MIN") or define("EMPTY_TIME_MIN", "1001-01-01"); // 小于该时间将被认为是null

// 对比关系标识
defined("COMPARE_EQ") or define("COMPARE_EQ", "eq"); // = 等于 equal
defined("COMPARE_NE") or define("COMPARE_NE", "ne"); // != 不等于 not equal
defined("COMPARE_GT") or define("COMPARE_GT", "gt"); // > 大于 greater than
defined("COMPARE_GE") or define("COMPARE_GE", "ge"); // >= 不小于 greater than or equal
defined("COMPARE_LT") or define("COMPARE_LT", "lt"); // < 小于 less than
defined("COMPARE_LE") or define("COMPARE_LE", "le"); // <= 不大于 less than or equal

// 排序字段标识
defined("ORDER_ASC") or define("ORDER_ASC", "ASC"); // 升序
defined("ORDER_DESC") or define("ORDER_DESC", "DESC"); // 降序

// 方向
defined("DIRECTION_NONE") or define("DIRECTION_NONE", "none"); // 无
defined("DIRECTION_UP") or define("DIRECTION_UP", "up"); // 上
defined("DIRECTION_DOWN") or define("DIRECTION_DOWN", "down"); // 下
defined("DIRECTION_LEFT") or define("DIRECTION_LEFT", "left"); // 左
defined("DIRECTION_RIGHT") or define("DIRECTION_RIGHT", "right"); // 右
defined("DIRECTION_BOTH") or define("DIRECTION_BOTH", "both"); // 两者兼有
defined("DIRECTION_ALL") or define("DIRECTION_ALL", "all"); // 所有

/**
 * header 常量
 */
defined('HEADER_HOST_INFO') or define('HEADER_HOST_INFO', 'x-portal-host-info'); // 多系统时传递的主机header头变量
defined('HEADER_IS_GUEST') or define('HEADER_IS_GUEST', 'x-portal-is-guest'); // 多系统时传递的是否登录header头变量
defined('HEADER_IS_SUPER') or define('HEADER_IS_SUPER', 'x-portal-is-super'); // 多系统时传递的登录用户是否超管的header头变量
defined('HEADER_LOGIN_UID') or define('HEADER_LOGIN_UID', 'x-portal-uid'); // 多系统时传递的登录用户id的header头变量
defined('HEADER_LOGIN_ACCOUNT') or define('HEADER_LOGIN_ACCOUNT', 'x-portal-account'); // 多系统时传递的登录用户account的header头变量
defined('HEADER_LOGIN_NICKNAME') or define('HEADER_LOGIN_NICKNAME', 'x-portal-nickname'); // 多系统时传递的登录用户account的header头变量
