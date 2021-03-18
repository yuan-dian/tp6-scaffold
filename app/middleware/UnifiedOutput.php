<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | @copyright (c) http://www.auntec.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/3/18
// +----------------------------------------------------------------------

namespace app\middleware;

use think\Request;
use think\Response;

/**
 * 统一输出【格式化响应数据】
 * Class UnifiedOutput
 * @package app\middleware
 */
class UnifiedOutput
{
    /**
     * 中间件执行方法
     * @param Request $request 请求信息
     * @param \Closure $next 闭包
     * @return mixed
     * @date 2020/4/24 13:31
     * @author 原点 467490186@qq.com
     */
    public function handle(Request $request, \Closure $next)
    {
        //前置中间件业务
        $response = $next($request);
        $data = $response->getData();

        // 自动格式化数据
        if (!isset($data['code']) && !isset($data['message'])) {
            $response = format_response($data);
        }
        return $response;
    }

    /**
     * 结束调度(请求结束前回调)
     * @param Response $response
     * @date 2020/4/24 13:30
     * @author 原点 467490186@qq.com
     */
    public function end(Response $response)
    {

    }

}