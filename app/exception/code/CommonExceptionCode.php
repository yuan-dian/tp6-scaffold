<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | @copyright (c) http://www.auntec.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2023/6/9
// +----------------------------------------------------------------------
namespace app\exception\code;

use app\Annotation\Message;
use app\exception\trait\EnumTrait;

enum CommonExceptionCode: int implements ICode
{
    use EnumTrait;

    #[Message('请求成功')]
    case SUCCESS = 0;
    #[Message('参数异常', 400)]
    case PARAM_ERROR = 1001;
    #[Message('非法请求', 401)]
    case ILLEGAL_REQUEST = 1002;
    #[Message('未知请求', 404)]
    case UNDEFINED_REQUEST = 1003;


    #[Message('请求失败', 500)]
    case DEFAULT_FAIL = 4001;
    #[Message('数据库异常', 404)]
    case MYSQL_ERROR = 4002;
    #[Message('数据库事务回滚', 404)]
    case MYSQL_ROLLBACK = 4003;
    #[Message('数据库保存失败', 404)]
    case MYSQL_SAVE_ERROR = 4004;

}
