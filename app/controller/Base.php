<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | @copyright (c) http://www.auntec.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2020/4/24
// +----------------------------------------------------------------------

namespace app\controller;

use app\BaseController;
use think\exception\HttpResponseException;

abstract class Base extends BaseController
{
    /**
     * 统一输出
     * @param array|string $data
     * @param int $code
     * @date 2020/4/23 13:12
     * @author 原点 467490186@qq.com
     */
    public function response($data = '', int $code = 0)
    {
        $response = format_response($data, $code);
        $response->send();
    }

}