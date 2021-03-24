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

/**
 * 业务异常
 * Class BusinessException
 * @package app\exception
 */
class BusinessException extends \RuntimeException
{
    public $httpCode = 500;

    /**
     * BusinessException constructor.
     * @param int $code 错误码
     * @param string $message 错误信息
     * @param int $httpCode http状态码
     */
    public function __construct(int $code = 0, string $message = '', int $httpCode = 0)
    {
        if (empty($message)) {
            $message = ResponseCode::getMessage($code);
        }
        if (empty($httpCode)) {
            $httpCode = ResponseCode::getHttpCode($code) ? (int)ResponseCode::getHttpCode($code) : 500;
        }
        $this->httpCode = $httpCode;
        $this->message = $message;
        $this->code = $code;
        parent::__construct($this->message, $this->code);
    }

}