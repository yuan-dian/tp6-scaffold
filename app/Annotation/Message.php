<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/6/18
// +----------------------------------------------------------------------

namespace app\Annotation;

use Attribute;

/**
 * 常量注解
 * Class Message
 * @package app\attribute
 */
#[Attribute(Attribute::TARGET_CLASS_CONSTANT)]
class Message
{

    private string $message;
    private int $httpCode;

    /**
     * Message constructor.
     * @param string $message 错误信息
     * @param int $httpCode http状态码
     */
    public function __construct(string $message, int $httpCode = 200)
    {
        $this->message = $message;
        $this->httpCode = $httpCode;
    }

    public function getDate(): array
    {
        return get_object_vars($this);
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getHttpCode(): int
    {
        return $this->httpCode;
    }
}