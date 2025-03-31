<?php
// +----------------------------------------------------------------------
// | 统一跨域处理
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/1/26
// +----------------------------------------------------------------------

namespace app\middleware;

use think\Request;
use think\Response;

/**
 * 全局跨域请求处理
 * Class CrossDomain
 * @package app\middleware
 */
class CrossDomain
{
    /**
     * @param Request $request
     * @param \Closure $next
     * @date 2021/1/26 11:00
     * @return Response
     * @author 原点 467490186@qq.com
     */
    public function handle(Request $request, \Closure $next): Response
    {
        // 判断是否是跨域请求
        if (!$this->isCorsRequest($request)) {
            return $next($request);
        }
        $header = [
            'Access-Control-Allow-Origin'  => $request->header('origin', '*'),
            'Access-Control-Allow-Headers' => $request->header(
                'Access-Control-Request-Headers',
                'Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-CSRF-TOKEN, X-Requested-With'
            ),
        ];
        // OPTIONS 预请求直接输出
        if ($request->method(true) == 'OPTIONS') {
            $header['Access-Control-Max-Age'] = 1800;
            $header['Access-Control-Allow-Methods'] = 'GET, POST, PATCH, PUT, DELETE, OPTIONS';
            return Response::create()->code(204)->header($header);
        }
        return $next($request)->header($header);
    }

    /**
     * 根据 和 Host headers 检查请求是否为同源请求Origin
     * 返回值: true 如果请求是同源请求， false 则为跨域请求
     * @param Request $request
     * @return bool
     * @date 2025/1/20 18:14
     * @author 原点 467490186@qq.com
     */
    private function isCorsRequest(Request $request): bool
    {
        $origin = $request->header('origin');
        if (empty($origin)) {
            return true;
        }

        $parse_url = parse_url($origin);

        return $parse_url['scheme'] == $request->scheme()
            && $parse_url['host'] == $request->host()
            && $parse_url['port'] == $request->port();
    }
}