<?php

// +----------------------------------------------------------------------
// | 自定义状态码类
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2020/5/3
// +----------------------------------------------------------------------

namespace app\response;

/**
 * 响应状态码
 * Class ResponseCode.
 * @method static string getMessage(int $code) 获取状态码对应的说明
 * @method static int getHttpCode(int $code) 获取状态码对应的HTTP 状态码
 */
class ResponseCode extends AbstractConstants
{
    /*
    1000-1999	请求错误（参数错误等）
    2000-2999	用户信息错误（包括权限等）
    3000-3999	系统错误（如数据库连接失败，创建文件失败等）
    4000-4999	自定义错误
    5000-5099   系统未知异常
    */

    /**
     * @Message("Success")
     * @HttpCode("200")
     */
    const SUCCESS = 0;

    // 请求错误
    /**
     * @Message("Params error")
     * @HttpCode("400")
     */
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

    // 系统错误
    // DB错误
    /**
     * @Message("Db error")
     * @HttpCode("500")
     */
    const MYSQL_ERROR = 3001;

    /**
     * @Message("Db rollback")
     * @HttpCode("500")
     */
    const MYSQL_ROLLBACK = 3002;

    /**
     * @Message("Db save error")
     * @HttpCode("500")
     */
    const MYSQL_SAVE_ERROR = 3003;


    // 自定义错误
    /**
     * @Message("Share password error")
     * @HttpCode("200")
     */
    const SHARE_PASSWORD_ERROR = 4001;

    /**
     * @Message("Share time error")
     * @HttpCode("200")
     */
    const SHARE_TIME_ERROR = 4002;

    /**
     * @Message("Share cancel")
     * @HttpCode("200")
     */
    const SHARE_CANCEL = 4003;

    /**
     * 非法访问
     * @Message("Illegal access")
     * @HttpCode("403")
     */
    const ILLEGAL_ACCESS_ERROR = 4004;
}
