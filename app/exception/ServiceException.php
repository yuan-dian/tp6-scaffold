<?php
// +----------------------------------------------------------------------
// | 业务异常类
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/3/24
// +----------------------------------------------------------------------

namespace app\exception;

use app\constants\BaseCode;
use app\constants\CommonCode;

/**
 * 业务异常
 * Class BusinessException
 * @package app\exception
 */
abstract class ServiceException extends \RuntimeException
{
    public int $httpCode = 500;
    /**
     * @var BaseCode
     */
    protected string $codeClass = CommonCode::class;

    public function __construct(int $code = 0, string $message = '', int $httpCode = 0)
    {
        if (empty($message)) {
            $message = $this->codeClass::getMessage($code);
        }
        if (empty($httpCode)) {
            $httpCode = (int)$this->codeClass::getHttpCode($code) ?: $this->httpCode;
        }
        $this->httpCode = $httpCode;
        $this->message = $message;
        $this->code = $code;
        parent::__construct($message, $code);
    }


}