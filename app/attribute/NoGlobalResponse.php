<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | @copyright (c) http://www.auntec.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2022/9/26
// +----------------------------------------------------------------------

namespace app\attribute;
use Attribute;
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class NoGlobalResponse
{
    public function __construct(){
        // 关闭统一输出
        app('request')->globalResponse = false;
    }

}