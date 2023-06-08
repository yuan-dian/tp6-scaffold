<?php
// +----------------------------------------------------------------------
// | 业务异常类
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/3/24
// +----------------------------------------------------------------------

namespace app\exception;

use app\constants\BusinessCode;

/**
 * 业务异常
 * Class BusinessException
 * @package app\exception
 */
class BusinessException extends ServiceException
{
    protected string $codeClass = BusinessCode::class;
}