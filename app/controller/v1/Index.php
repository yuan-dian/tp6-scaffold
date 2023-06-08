<?php
// +----------------------------------------------------------------------
// | v1版本默认控制器
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2020/4/22
// +----------------------------------------------------------------------

namespace app\controller\v1;

use app\attribute\NoGlobalResponse;
use app\constants\ErrorCode;
use app\controller\Base;
use app\exception\ErrorException;

#[NoGlobalResponse]
class Index extends Base
{
    #[NoGlobalResponse]
    public function index()
    {
        throw new ErrorException(ErrorCode::FAIL);
//        return 'Welcome to v1 *****';
    }
}