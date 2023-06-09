<?php
// +----------------------------------------------------------------------
// | 业务异常类
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/3/24
// +----------------------------------------------------------------------

namespace app\exception;

use app\exception\trait\EnumTrait;
use BackedEnum;

/**
 * 业务异常
 * Class BusinessException
 * @package app\exception
 */
abstract class ServiceException extends \RuntimeException
{
    protected int $httpCode = 500;

    /**
     * @param EnumTrait|BackedEnum $codeEnum
     * @param string $message
     * @param int $httpCode
     */
    public function __construct($codeEnum, string $message = '', int $httpCode = 0)
    {
        if (empty($message)) {
            $message = $codeEnum->getMessage();
        }
        if (empty($httpCode)) {
            $httpCode = $codeEnum->getHttpCode();
        }
        $this->httpCode = $httpCode;
        $this->message = $message;
        $this->code = $codeEnum->value;
        parent::__construct($message, $codeEnum->value);
    }

    /**
     * @return int
     */
    public function getHttpCode(): int
    {
        return $this->httpCode;
    }


}