<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/6/16
// +----------------------------------------------------------------------

namespace app\response;

/**
 * 统一输出对象
 */
class Result
{
    private int $code = 0;

    private string $message = 'success';

    private $data;
    private int $httpCode = 200;


    /**
     * @return int
     * @date 2021/6/16 14:01
     * @author 原点 467490186@qq.com
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @param int $code
     * @return $this
     * @date 2021/6/16 14:01
     * @author 原点 467490186@qq.com
     */
    public function setCode(int $code): Result
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     * @date 2021/6/16 14:01
     * @author 原点 467490186@qq.com
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return $this
     * @date 2021/6/16 14:01
     * @author 原点 467490186@qq.com
     */
    public function setMessage(string $message): Result
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return mixed
     * @date 2021/6/16 14:01
     * @author 原点 467490186@qq.com
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param $data
     * @return $this
     * @date 2021/6/16 14:01
     * @author 原点 467490186@qq.com
     */
    public function setData($data): Result
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return int
     * @date 2021/6/16 14:01
     * @author 原点 467490186@qq.com
     */
    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    /**
     * @param int $httpCode
     * @return $this
     * @date 2021/6/16 14:01
     * @author 原点 467490186@qq.com
     */
    public function setHttpCode(int $httpCode): Result
    {
        $this->httpCode = $httpCode;
        return $this;
    }

    /**
     * 对象转字符串
     * @return string
     * @date 2021/6/18 13:05
     * @author 原点 467490186@qq.com
     */
    public function __toString(): string
    {
        return json_encode($this->__toArray());
    }

    /**
     * 对象转数组
     * @return array
     * @date 2021/6/18 13:05
     * @author 原点 467490186@qq.com
     */
    public function __toArray(): array
    {
        return get_object_vars($this);
    }
}