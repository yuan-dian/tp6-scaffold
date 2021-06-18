<?php
// 应用公共文件
use think\facade\Request;
use think\Response;
use app\response\Result;

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
            'code' => $result->getCode(),
            'message' => $result->getMessage(),
        ];
        $httpCode = $result->getHttpCode();
        $data['data'] = $result->getData() ?: new stdClass();

        $Accept = Request::header('accept') ?: 'application/json';
        switch ($Accept) {
            case 'application/xml':
                $response = xml($data, $httpCode);
                break;
            case 'application/jsonp':
                $response = jsonp($data, $httpCode);
                break;
            case 'application/html':
                $response = response($data, $httpCode);
                break;
            default:
                $response = json($data, $httpCode);
                break;
        }

        return $response;
    }
}
