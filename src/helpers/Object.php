<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper;

use Zf\Helper\Exceptions\ClassException;
use \ReflectionClass;
use \ReflectionException;

class Object
{
    /**
     * 创建类对象，类中可以实例户
     *
     * @param mixed $config
     * @return mixed
     *
     * @throws ClassException
     * @throws ReflectionException
     */
    public static function create($config)
    {
        if (!is_array($config)) {
            $config = ['class' => $config];
        }
        if (!isset($config['class'])) {
            throw new ClassException('创建类实例配置中必须包含"class"元素', 1010005001);
        }

        $className = $config['class'];
        unset($config['class']);

        if (($n = func_num_args()) > 1) {
            $args  = func_get_args();
            $class = new ReflectionClass($className);
            unset($args[0]);
            // Note: ReflectionClass::newInstanceArgs() is available for PHP 5.1.3+
            // $object=$class->newInstanceArgs($args);
            $object = call_user_func_array([$class, 'newInstance'], $args);
        } else {
            $object = new $className;
        }
        // 设置对象属性
        $object->configure($config);
        if (method_exists($object, 'init')) {
            $object->init();
        }
        return $object;
    }

    /**
     * 获取类反射
     *
     * @param mixed $class
     * @return ReflectionClass
     *
     * @throws ReflectionException
     */
    public static function getReflection($class)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }
        return new ReflectionClass($class);
    }
}