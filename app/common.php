<?php
// 应用公共文件
use app\response\ResponseCode;
use think\facade\Request;
use think\Response;

if (!function_exists('format_response')) {
    /**
     * 统一输出.
     * @param mixed $data 输出数据
     * @param int $code 状态码
     * @param string $message 提示信息
     * @param int $httpCode http状态码
     * @return array|\think\Response|\think\response\Json|\think\response\Jsonp|\think\response\Xml
     * @date 2021/3/19 9:30
     * @author 原点 467490186@qq.com
     */
    function format_response($data = [], int $code = 0, string $message = '', int $httpCode = 200): Response
    {
        if (empty($message)) {
            $message = ResponseCode::getMessage($code) ?: '';
        }
        if (empty($httpCode)) {
            $httpCode = ResponseCode::getHttpCode($code) ? (int)ResponseCode::getHttpCode($code) : 200;
        }
        $response = [
            'code' => $code,
            'message' => $message,
        ];

        // 不存在数据data 则返回空对象，保持数据格式一致
        $response['data'] = $data ? $data : new stdClass();

        $Accept = Request::header('accept') ?: 'application/json';
        switch ($Accept) {
            case 'application/json':
                $response = json($response, $httpCode);
                break;
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
