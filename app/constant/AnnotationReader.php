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

use ReflectionClassConstant;

/**
 * 获取常量注释
 * Class AnnotationReader
 * @package app\constant
 */
class AnnotationReader
{
    /**
     * 获取知道类的注释
     * @param array $classConstants 类名
     * @return array
     */
    public function getAnnotations($classConstants)
    {
        $result = [];
        /** @var ReflectionClassConstant $classConstant */
        foreach ($classConstants as $classConstant) {
            $code = $classConstant->getValue();
            $docComment = $classConstant->getDocComment();
            if ($docComment) {
                $result[$code] = $this->parse($docComment);
            }
        }

        return $result;
    }

    /**
     * 格式注释内容
     * @param $doc
     * @return array
     */
    protected function parse($doc)
    {
        $pattern = '/\\@(\\w+)\\(\\"(.+)\\"\\)/U';
        if (preg_match_all($pattern, $doc, $result)) {
            if (isset($result[1], $result[2])) {
                $keys = $result[1];
                $values = $result[2];

                $result = [];
                foreach ($keys as $i => $key) {
                    if (isset($values[$i])) {
                        $key = mb_strtolower($key, 'UTF-8');
                        $result[$key] = $values[$i];
                    }
                }
                return $result;
            }
        }

        return [];
    }

}