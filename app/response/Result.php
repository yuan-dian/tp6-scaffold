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
    /**
     * 状态码
     * @var int
     */
    private int $code = 0;

    /**
     * 提示信息
     * @var string
     */
    private string $message = '请求成功';

    /**
     * 真实数据
     * @var mixed
     */
    private mixed $data = '';

    /**
     * 分页数据
     * @var array
     */
    private array $pageInfo = [];

    /**
     * 获取分页信息
     * @return array
     * @date 2023/11/17 15:45
     * @author 原点 467490186@qq.com
     */
    public function getPageInfo(): array
    {
        return $this->pageInfo;
    }

    /**
     * 设置分页信息
     * @param int $pageNumber
     * @param int $total
     * @param int $pageSize
     * @return $this
     * @date 2023/11/17 15:45
     * @author 原点 467490186@qq.com
     */
    public function setPageInfo(int $pageNumber, int $total, int $pageSize = 20): Result
    {
        $this->pageInfo = [
            'pageNumber' => $pageNumber,
            'pageSize'   => $pageSize,
            'total'      => $total,
        ];
        return $this;
    }

    /**
     * http状态码
     * @var int
     */
    private int $httpCode = 200;

    /**
     * header
     * @var array
     */
    private array $header = [];


    /**
     * 获取状态码
     * @return int
     * @date 2021/6/16 14:01
     * @author 原点 467490186@qq.com
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * 设置状态码
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
     * 获取提示信息
     * @return string
     * @date 2021/6/16 14:01
     * @author 原点 467490186@qq.com
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * 设置提示信息
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
     * 获取数据
     * @return mixed
     * @date 2021/6/16 14:01
     * @author 原点 467490186@qq.com
     */
    public function getData(): mixed
    {
        return $this->data;
    }

    /**
     * 设置数据
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
     * 获取http状态码
     * @return int
     * @date 2021/6/16 14:01
     * @author 原点 467490186@qq.com
     */
    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    /**
     * 设置http状态么
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
     * 获取header
     * @return array
     * @date 2023/9/7 10:52
     * @author 原点 467490186@qq.com
     */
    public function getHeader(): array
    {
        return $this->header;
    }

    /**
     * 设置header
     * @param array $header
     * @return $this
     * @date 2023/9/7 10:52
     * @author 原点 467490186@qq.com
     */
    public function setHeader(array $header): Result
    {
        $this->header = $header;
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
        $data = [
            'code'    => $this->getCode(),
            'message' => $this->getMessage(),
        ];
        if ($this->getData()) {
            $data['data'] = $this->getData();
        }
        return $data;
    }
}