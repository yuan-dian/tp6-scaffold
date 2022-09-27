<?php
// +----------------------------------------------------------------------
// | v1版本默认控制器
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2020/4/22
// +----------------------------------------------------------------------

namespace app\controller\v1;

use app\controller\Base;
use app\attribute\NoGlobalResponse;

#[NoGlobalResponse]
class Index extends Base
{
    #[NoGlobalResponse]
    public function index()
    {
        return 'Welcome to v1 *****';
    }
}