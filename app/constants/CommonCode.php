<?php

// +----------------------------------------------------------------------
// | 自定义状态码类
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2020/5/3
// +----------------------------------------------------------------------

namespace app\constants;

use app\attribute\Message;

/**
 * 公共状态码
 * Class ErrorCode.
 */
class CommonCode extends BaseCode
{
    /**
     * @Message("Success")
     * @HttpCode("200")
     */
    #[Message("请求成功")]
    const SUCCESS = 0;

    /**
     * 请求失败
     * @Message("请求失败")
     * @HttpCode("403")
     */
    const FAIL = 5000;

    // 请求错误
    /**
     * @Message("Params error")
     * @HttpCode("400")
     */
    #[Message("Params error", 400)]
    const PARAM_ERROR = 1001;

    /**
     * @Message("Illegal request")
     * @HttpCode("401")
     */
    const ILLEGAL_REQUEST = 1002;

    /**
     * @Message("Undefined request")
     * @HttpCode("404")
     */
    const NO_REQUEST = 1003;

    /**
     * @Message("Sign error")
     * @HttpCode("403")
     */
    const SIGN_ERROR = 1004;
}
