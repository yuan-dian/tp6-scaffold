<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | @copyright (c) 原点 All rights reserved.
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2023/6/9
// +----------------------------------------------------------------------
namespace app\exception\code;

use app\Annotation\Message;
use app\exception\trait\EnumTrait;

enum BusinessExceptionCode: int implements ICode
{
    use EnumTrait;

    #[Message('系统错误', 200)]
    case DEFAULT_CODE = 3000;

}
