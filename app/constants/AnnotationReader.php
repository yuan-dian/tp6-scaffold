<?php

// +----------------------------------------------------------------------
// | 状态码处理类
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2019/9/16
// +----------------------------------------------------------------------

namespace app\constants;

use app\attribute\Message;
use ReflectionClassConstant;

/**
 * 获取常量注释
 * Class AnnotationReader.
 */
class AnnotationReader
{
    /**
     * 获取类的注释.
     *
     * @param array $classConstants 类名
     *
     * @return array
     */
    public function getAnnotations(array $classConstants): array
    {
        $result = [];
        /** @var ReflectionClassConstant $classConstant */
        foreach ($classConstants as $classConstant) {
            $code = $classConstant->getValue();
            if (PHP_VERSION_ID >= 80000 && $ConstantAttribute = $classConstant->getAttributes(Message::class)) {
                foreach ($ConstantAttribute as $attribute) {
                    list($message, $httpCode) = ($attribute->newInstance())->getDate();
                    $result[$code] = [
                        'message' => mb_strtolower($message, 'UTF-8'),
                        'httpcode' => $httpCode,
                    ];
                }
                continue;
            }
            $docComment = $classConstant->getDocComment();
            if ($docComment && (is_int($code) || is_string($code))) {
                $result[$code] = $this->parse($docComment);
            }
        }
        return $result;
    }

    /**
     * 格式注释内容.
     * @param string $doc
     * @return array
     * @date 2023/2/1 16:06
     * @author 原点 467490186@qq.com
     */
    protected function parse(string $doc): array
    {
        $message = [];
        $pattern = '/\\@(\\w+)\\(\\"(.+)\\"\\)/U';
        if (preg_match_all($pattern, $doc, $result)) {
            if (isset($result[1], $result[2])) {
                $keys = $result[1];
                $values = $result[2];

                foreach ($keys as $i => $key) {
                    if (isset($values[$i])) {
                        $key = mb_strtolower($key, 'UTF-8');
                        $message[$key] = $values[$i];
                    }
                }

            }
        }
        return $message;
    }
}
