<?php
// +----------------------------------------------------------------------
// | 业务异常类
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/3/24
// +----------------------------------------------------------------------

namespace app\exception;

use app\exception\code\BusinessExceptionCode;


/**
 * 业务异常
 * Class BusinessException
 * @package app\exception
 */
class BusinessException extends ServiceException
{
    protected int $httpCode = 200;

    public function __construct(BusinessExceptionCode $code, string $message = '', int $httpCode = 0)
    {
        $this->httpCode = $httpCode ?: $this->httpCode;
        parent::__construct($code, $message, $this->httpCode);
    }
}