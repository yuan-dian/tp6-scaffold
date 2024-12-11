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
        // OPTIONS 预请求直接输出
        if (strtoupper($request->method()) == "OPTIONS") {
            $header = [
                'Access-Control-Allow-Origin'  => $request->header('origin', '*'),
                'Access-Control-Max-Age'       => 1800,
                'Access-Control-Allow-Methods' => 'GET, POST, PATCH, PUT, DELETE, OPTIONS',
                'Access-Control-Allow-Headers' => $request->header(
                    'Access-Control-Request-Headers',
                    'Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-CSRF-TOKEN, X-Requested-With'
                ),
            ];
            return Response::create('', 'json', '204')->header($header);
        }

        // 实际请求只需要增加Access-Control-Allow-Origin头即可
        $header = [
            'Access-Control-Allow-Origin' => $request->header('origin', '*'),
        ];
        return $next($request)->header($header);
    }
}