<?php

// +----------------------------------------------------------------------
// | 状态码枚举基类
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2020/5/3
// +----------------------------------------------------------------------

namespace app\constants;

use think\Exception;
use think\facade\Cache;
use think\helper\Str;

/**
 * 常量定义抽象类
 * Class AbstractConstants.
 */
abstract class AbstractConstants
{
    /**
     * @throws \ReflectionException
     * @throws Exception
     */
    public static function __callStatic($name, $arguments)
    {
        if (false === Str::startsWith($name, 'get')) {
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

        $lang_key = $message[$code][$name] ?? 'Undefined error';
        return lang($lang_key);
    }

    /**
     * 获取响应状态码相关信息
     *
     * @return array
     * @throws \ReflectionException
     */
    public static function getResponseCodes(): array
    {
        $class = get_called_class();
        $reader = new AnnotationReader();
        $ref = new \ReflectionClass($class);
        $classConstants = $ref->getReflectionConstants();

        return $reader->getAnnotations($classConstants);
    }
}
