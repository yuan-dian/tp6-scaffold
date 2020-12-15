<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | @copyright (c) http://www.auntec.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2020/4/22
// +----------------------------------------------------------------------

namespace app\controller\v1;

use app\controller\Base;
use app\response\ResponseCode;

class Index extends Base
{
    public function index()
    {
        $this->response('Welcome to v1 *****',ResponseCode::SUCCESS);
    }
}