<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | @copyright (c) 原点 All rights reserved.
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2023/6/9
// +----------------------------------------------------------------------
namespace app\exception;

use app\exception\code\CommonExceptionCode;

class CommonException extends ServiceException
{
    protected int $httpCode = 500;

    public function __construct(CommonExceptionCode $code, string $message = '', int $httpCode = 0)
    {
        $this->httpCode = $httpCode ?: $this->httpCode;
        parent::__construct($code, $message, $this->httpCode);
    }
}