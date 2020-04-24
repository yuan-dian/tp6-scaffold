<?php
// 应用公共文件
use app\constant\ReturnCode;
use think\facade\Request;

if (!function_exists('show')) {
    /**
     * 统一输出
     * @param array|bool $data 输出数据
     * @param int $code 状态码
     * @param string $message 提示信息
     * @param int $httpCode http状态码
     * @return array|\think\Response|\think\response\Json|\think\response\Jsonp|\think\response\Xml
     */
    function show($data, $code = 0, $message = null, $httpCode = null) : \think\Response
    {
        if (is_null($message)) {
            $message = ReturnCode::getMessage($code) ?: '';
        }
        if (is_null($httpCode)) {
            $httpCode = ReturnCode::getHttpCode($code) ? (int)ReturnCode::getHttpCode($code) : 200;
        }
        $response = [
            'code' => $code,
            'message' => $message,
        ];

        $response['data'] = $data;

        $Accept = Request::header('accept') ?: 'application/json';
        switch ($Accept) {
            case 'application/json' :
                $response = json($response, $httpCode);
                break;
            case 'application/xml' :
                $response = xml($response, $httpCode);
                break;
            case 'application/jsonp' :
                $response = jsonp($response, $httpCode);
                break;
            case 'application/html' :
                $response = response($response, $httpCode);
                break;
            default:
                $response = json($response, $httpCode);
                break;
        }
        return $response;
    }
}
