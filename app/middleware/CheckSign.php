<?php
// +----------------------------------------------------------------------
// | 统一认证
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2019/8/28
// +----------------------------------------------------------------------

namespace app\middleware;

use think\Request;
use think\Response;

/**
 * 验证签名
 * Class CheckSign
 * @package app\middleware
 */
class CheckSign
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


        //后置中间件业务


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