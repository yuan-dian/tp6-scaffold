<?php

// +----------------------------------------------------------------------
// |
// +----------------------------------------------------------------------
// | @copyright (c) http://www.auntec.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2020/5/3
// +----------------------------------------------------------------------

namespace app\response;

use think\Exception;
use think\facade\Cache;

/**
 * 常量定义抽象类
 * Class AbstractConstants.
 */
abstract class AbstractConstants
{
    public static function __callStatic($name, $arguments)
    {
        if (!self::starts_with($name, 'get')) {
            throw new Exception('方法名错误');
        }

        if (!isset($arguments) || 0 === count($arguments)) {
            throw new Exception('参数不能为空');
        }

        $code = $arguments[0];
        $name = strtolower(substr($name, 3));

        $debug = env('app_debug');
        // 应用调试模式 不走缓存 方便开发调试
        if ($debug) {
            $message = self::getResponseCodes();
        } else {
            $message = Cache::get('response_code');

            if (!$message || !isset($message[$code])) {
                $message = self::getResponseCodes();
                Cache::set('response_code', $message, 3600);
            }
        }

        $lang_key = isset($message[$code][$name]) ? $message[$code][$name] : 'Undefined error';

        return lang($lang_key);
    }

    /**
     * 获取响应状态码相关信息
     *
     * @return array
     * @throws \ReflectionException
     */
    public static function getResponseCodes()
    {
        $class = get_called_class();
        $reader = new AnnotationReader();
        $ref = new \ReflectionClass($class);
        $classConstants = $ref->getReflectionConstants();

        return $reader->getAnnotations($classConstants);
    }

    /**
     * 验证字符串是否以指定字符开始.
     * @param $haystack
     * @param $needle
     * @return bool
     * @date 2020/11/30 11:07
     * @author 原点 467490186@qq.com
     */
    private static function starts_with($haystack, $needle)
    {
        if ('' !== $needle && substr($haystack, 0, strlen($needle)) === (string)$needle) {
            return true;
        }

        return false;
    }
}
