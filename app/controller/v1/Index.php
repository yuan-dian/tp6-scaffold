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

class Index extends Base
{
    public function index()
    {
        return 'Welcome to v1 *****';
    }
}