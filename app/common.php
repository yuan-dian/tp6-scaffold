<?php
// 应用公共文件
use think\facade\Request;
use think\Response;

if (!function_exists('format_response')) {
    /**
     * 统一输出.
     * @param mixed $data 输出数据
     * @param int $code 状态码
     * @param string $message 提示信息
     * @param int $httpCode http状态码
     * @return Response
     * @date 2021/6/16 17:28
     * @author 原点 467490186@qq.com
     */
    function format_response($data = [], int $code = 0, string $message = 'success', int $httpCode = 200): Response
    {
        $response = [
            'code' => $code,
            'message' => $message,
        ];

        // 不存在数据data 则返回空对象，保持数据格式一致
        $response['data'] = $data ?: new stdClass();

        $Accept = Request::header('accept') ?: 'application/json';
        switch ($Accept) {
            case 'application/xml':
                $response = xml($response, $httpCode);
                break;
            case 'application/jsonp':
                $response = jsonp($response, $httpCode);
                break;
            case 'application/html':
                $response = response($response, $httpCode);
                break;
            default:
                $response = json($response, $httpCode);
                break;
        }

        return $response;
    }
}
