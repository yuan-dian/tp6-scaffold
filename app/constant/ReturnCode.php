<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | @copyright (c) http://www.auntec.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2019/9/16
// +----------------------------------------------------------------------

namespace app\constant;
/**
 * 状态码
 * Class ErrorCode
 * @package app\constant
 */
class ReturnCode extends AbstractConstants
{
    /*
    1000-1999	请求错误（参数错误等）
    2000-2999	用户信息错误（包括权限等）
    3000-3999	系统错误（如数据库连接失败，创建文件失败等）
    4000-4999	自定义错误
    5000-5099   系统未知异常
    */

    /**
     * 成功
     * @Message("成功")
     * @HttpCode("200")
     */
    const SUCCESS = 0;

    /**
     * 参数错误
     * @Message("参数错误")
     * @HttpCode("400")
     */
    const PARAM_ERROR= 1001;

    /**
     * 非法请求
     * @Message("非法请求")
     * @HttpCode("401")
     */
    const ILLEGAL_REQUEST = 1002;

    /**
     * 请求不存在
     * @Message("请求不存在")
     * @HttpCode("404")
     */
    const NO_REQUEST = 1003;

    /**
     * 签名错误
     * @Message("签名错误")
     * @HttpCode("403")
     */
    const SIGN_ERROR = 1004;


    //系统错误

    /**
     * 数据库访问失败
     * @Message("数据库访问失败")
     * @HttpCode("500")
     */
    const MYSQL_ERROR = 3001;

    /**
     * 数据库事务回滚
     * @Message("数据库事务回滚")
     * @HttpCode("500")
     */
    const MYSQL_ROLLBACK= 3002;

    /**
     * 数据保存失败
     * @Message("数据保存失败")
     * @HttpCode("500")
     */
    const MYSQL_SAVE_ERROR= 3003;


}