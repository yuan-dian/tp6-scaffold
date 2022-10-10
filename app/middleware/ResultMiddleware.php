<?php
// +----------------------------------------------------------------------
// | 统一响应结果处理
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/3/18
// +----------------------------------------------------------------------

namespace app\middleware;

use app\attribute\NoGlobalResponse;
use app\response\Result;
use think\facade\Env;
use think\facade\Log;
use think\Request;
use think\Response;

/**
 * 统一输出【格式化响应数据】
 * Class ResultMiddleware
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
        $request->globalResponse = true;
        /**
         * @var Response $response
         */
        $response = $next($request);
        // php 大于8.0 才支持注解
        if (PHP_VERSION_ID >= 80000 && $request->globalResponse) {
            try {
                $class = $request->controller();
                $action = $request->action();
                $class = str_replace('.', '\\', $class);
                $ref = new \ReflectionClass('\\app\\controller\\' . $class);

                foreach ($ref->getAttributes(NoGlobalResponse::class) as $attribute) {
                    $attribute->newInstance();
                }
                foreach ($ref->getMethod($action)->getAttributes(NoGlobalResponse::class) as $attribute) {
                    $attribute->newInstance();
                }
            }catch (\Throwable $e) {
                Log::write($e);
            }
        }
        // debug 模式 且http状态码为500时直接输出
        if ((Env::get('app_debug', false) && $response->getCode() == 500) || false === $request->globalResponse) {
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
        // 增加API请求响应日志
        $api_log = \request()->param('apiLog', false);
        if ($api_log === true) {
            $log = [
                'route' => \request()->url(true),
                'param' => \request()->param(),
                'header' => \request()->header(),
                'response' => $response->getContent(),
                'http_code' => $response->getCode(),
            ];
            Log::write($log);
        }
    }

}