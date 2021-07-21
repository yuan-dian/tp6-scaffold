<?php
// +----------------------------------------------------------------------
// | 统一响应结果处理
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/3/18
// +----------------------------------------------------------------------

namespace app\middleware;

use app\response\Result;
use think\facade\Env;
use think\Request;
use think\Response;

/**
 * 统一输出【格式化响应数据】
 * Class UnifiedOutput
 * @package app\middleware
 */
class ResultMiddleware
{
    /**
     * 中间件执行方法
     * @param Request $request 请求信息
     * @param \Closure $next 闭包
     * @return Response
     * @date 2020/4/24 13:31
     * @author 原点 467490186@qq.com
     */
    public function handle(Request $request, \Closure $next): Response
    {
        $request->unifiedOutput = true;
        /**
         * @var Response $response
         */
        $response = $next($request);

        // debug 模式 且http状态码为500时直接输出
        if ((true == Env::get('app_debug', false) && $response->getCode() == 500) || false === $request->unifiedOutput) {
            return $response;
        }
        $data = $response->getData();

        if (!$data instanceof Result) {
            $data =  (new Result())->setData($data);
        }
        return format_response($data);
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