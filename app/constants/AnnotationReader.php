<?php

// +----------------------------------------------------------------------
// | 状态码处理类
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2019/9/16
// +----------------------------------------------------------------------

namespace app\constants;

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
            $docComment = $classConstant->getDocComment();
            if ($docComment && (is_int($code) || is_string($code))) {
                $result[$code] = $this->parse($docComment);
            }
        }

        return $result;
    }

    /**
     * 格式注释内容.
     *
     * @param $doc
     *
     * @return array
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
