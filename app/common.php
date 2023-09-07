<?php
// 应用公共文件
use app\response\Result;
use think\facade\Request;
use think\Response;

if (!function_exists('format_response')) {
    /**
     * 统一输出.
     * @param Result $result
     * @return Response
     * @date 2021/6/18 13:37
     * @author 原点 467490186@qq.com
     */
    function format_response(Result $result): Response
    {
        $data = [
            'code'    => $result->getCode(),
            'message' => $result->getMessage(),
        ];
        $httpCode = $result->getHttpCode();
        if ($result->getData()) {
            $data['data'] = $result->getData();
        }
        $header = $result->getHeader();

        $Accept = Request::header('accept') ?: 'application/json';
        return match ($Accept) {
            'application/xml' => xml($data, $httpCode, $header),
            'application/jsonp' => jsonp($data, $httpCode, $header),
            'application/html' => response($data, $httpCode, $header),
            default => json($data, $httpCode, $header),
        };
    }
}

/**
 * 关闭统一输出
 * @date 2021/7/21 18:32
 * @author 原点 467490186@qq.com
 */
if (!function_exists('no_global_response')) {
    function no_global_response(): void
    {
        request()->globalResponse = false;
    }
}

