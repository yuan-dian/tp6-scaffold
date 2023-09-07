<?php
// +----------------------------------------------------------------------
// | 统一响应结果处理
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/3/18
// +----------------------------------------------------------------------

namespace app\middleware;

use app\Annotation\NoGlobalResponse;
use app\response\Result;
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

        // 获取响应数据
        $data = $response->getData();
        if ($data instanceof Result) {
            return format_response($data);
        }
        // 检查是否需要统一输出
        if ($this->checkGlobalResponse($request)) {
            $data = (new Result())->setData($data);
            $response = format_response($data);
        }
        return $response;
    }

    /**
     * 设置是否统一输出
     * @param Request $request
     * @return bool
     * @date 2022/10/20 17:00
     * @author 原点 467490186@qq.com
     */
    private function checkGlobalResponse(Request $request): bool
    {
        if ($request->globalResponse === false) {
            return false;
        }
        try {
            // 解析控制器
            $class = app()->parseClass('controller', $request->controller());
            $action = $request->action();
            // 判断类是否存在
            if (!class_exists($class) || !method_exists($class, $action)) {
                return true;
            }
            $ref = new \ReflectionClass($class);
            $attribute = $ref->getAttributes(NoGlobalResponse::class);
            if ($attribute) {
                return false;
            }
            $attribute = $ref->getMethod($action)->getAttributes(NoGlobalResponse::class);
            if ($attribute) {
                return false;
            }
        } catch (\Throwable) {
        }
        return true;
    }

    /**
     * 结束调度(请求结束前回调)
     * @param Response $response
     * @date 2020/4/24 13:30
     * @author 原点 467490186@qq.com
     */
    public function end(Response $response): void
    {
        // 增加API请求响应日志
        $api_log = \request()->param('apiLog', false);
        if ($api_log === true) {
            $header = \request()->header();
            unset($header['cookie'], $header['accept'], $header['host'], $header['connection']);
            $log = [
                'route'     => \request()->baseUrl(true),
                // get 参数
                'GET'       => \request()->get(),
                // post参数
                'POST'      => \request()->post() ?: \request()->getInput(),
                'header'    => $header,
                'response'  => $response->getContent(),
                'http_code' => $response->getCode(),
            ];
            Log::write($log);
        }
    }

}