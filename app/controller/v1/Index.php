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

use app\constant\ReturnCode;
use app\controller\Base;

class Index extends Base
{
    public function index()
    {
        $this->response('Welcome to v1 *****',ReturnCode::SUCCESS);
    }
}