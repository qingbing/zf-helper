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
defined('SEX_UNKNOWN') or define('SEX_UNKNOWN', 0);
defined('SEX_MALE') or define('SEX_MALE', 1);
defined('SEX_FEMALE') or define('SEX_FEMALE', 2);
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
