<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | @copyright (c) http://www.auntec.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2023/6/7
// +----------------------------------------------------------------------
namespace app\constants;


/**
 * 响应状态码
 * Class ErrorCode.
 * @method static string getMessage(int $code) 获取状态码对应的说明
 * @method static int getHttpCode(int $code) 获取状态码对应的HTTP 状态码
 */
abstract class BaseCode extends AbstractConstants
{

}