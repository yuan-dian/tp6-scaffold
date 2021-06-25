<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/6/18
// +----------------------------------------------------------------------

namespace app\constants;
use Attribute;
#[Attribute(Attribute::TARGET_CLASS_CONSTANT|Attribute::IS_REPEATABLE)]
class MyAttribute
{
    public $data = [];
    public function __construct(public $name, public $value) {
       $this->data = [$name,$value];
    }

    public function getDate(){
        return $this->data;
    }


}