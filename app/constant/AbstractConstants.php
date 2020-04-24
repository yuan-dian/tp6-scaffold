<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | @copyright (c) http://www.auntec.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2019/9/16
// +----------------------------------------------------------------------

namespace app\constant;

use think\Exception;
use think\facade\Cache;

/**
 * 常量定义抽象类
 * Class AbstractConstants
 * @package app\constant
 */
abstract class AbstractConstants
{
    public static function __callStatic($name, $arguments)
    {
        if (!self::starts_with($name, 'get')) {
            throw new Exception('方法名错误');
        }

        if (!isset($arguments) || count($arguments) === 0) {
            throw new Exception('参数不能为空');
        }

        $code = $arguments[0];
        $name = strtolower(substr($name, 3));
        $class = get_called_class();
        $message = Cache::get('error_message');
        if (!$message || !isset($message[$class])  || !isset($message[$class][$code])) {
            $reader = new AnnotationReader();
            $ref = new \ReflectionClass($class);
            $classConstants = $ref->getReflectionConstants();
            $data = $reader->getAnnotations($classConstants);
            $message[$class] = $data;
            Cache::set('error_message', $message, 3600);
        }
        return isset($message[$class][$code][$name]) ? $message[$class][$code][$name] : '未知信息';
    }

   protected static function starts_with($haystack, $needle)
    {
        if ($needle !== '' && substr($haystack, 0, strlen($needle)) === (string)$needle) {
            return true;
        }
        return false;
    }

}