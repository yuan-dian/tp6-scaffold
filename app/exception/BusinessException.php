<?php
// +----------------------------------------------------------------------
// | 业务异常类
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/3/24
// +----------------------------------------------------------------------

namespace app\exception;

use app\constants\ErrorCode;

/**
 * 业务异常
 * Class BusinessException
 * @package app\exception
 */
class BusinessException extends ServiceException
{
    public $httpCode = 500;

    /**
     * BusinessException constructor.
     * @param int $code 错误码
     * @param string $message 错误信息
     * @param int $httpCode http状态码
     */
    public function __construct(int $code = 0, string $message = '', int $httpCode = 500)
    {
        if (empty($message)) {
            $message = ErrorCode::getMessage($code);
        }
        if (empty($httpCode)) {
            $httpCode = ErrorCode::getHttpCode($code) ?: 500;
        }
        $this->httpCode = $httpCode;
        $this->message = $message;
        $this->code = $code;
    }

}