<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | @copyright (c) http://www.auntec.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/3/24
// +----------------------------------------------------------------------

namespace app\exception;

use app\response\ResponseCode;
use think\Exception;

/**
 * 业务异常
 * Class BusinessException
 * @package app\exception
 */
class BusinessException extends Exception
{
    public $message = '';
    public $httpCode = 500;
    public $code = 0;

    /**
     * BusinessException constructor.
     * @param int $code 错误码
     * @param null $message 错误信息
     * @param null $httpCode http状态码
     */
    public function __construct(int $code, $message = null, $httpCode = null)
    {
        if (is_null($message)) {
            $message = ResponseCode::getMessage($code);
        }
        if (is_null($httpCode)) {
            $httpCode = ResponseCode::getHttpCode($code) ? (int)ResponseCode::getHttpCode($code) : 200;
        }
        $this->httpCode = $httpCode;
        $this->message = $message;
        $this->code = $code;
    }

}