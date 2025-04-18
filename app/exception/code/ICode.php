<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | @copyright (c) 原点 All rights reserved.
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2023/8/29
// +----------------------------------------------------------------------
namespace app\exception\code;

interface ICode
{
    /**
     * 获取状态码提示信息
     * @return string
     * @date 2023/8/29 13:53
     * @author 原点 467490186@qq.com
     */
    public function getMessage(): string;

    /**
     * 获取状态码对应的http状态码
     * @return int
     * @date 2023/8/29 13:54
     * @author 原点 467490186@qq.com
     */
    public function getHttpCode(): int;

}