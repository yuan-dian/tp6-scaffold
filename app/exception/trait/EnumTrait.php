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
namespace app\exception\trait;

use app\Annotation\Message;

trait EnumTrait
{

    /**
     * 获取状态码提示信息
     * @return string
     * @date 2023/8/29 13:52
     * @author 原点 467490186@qq.com
     */
    public function getMessage(): string
    {
        $ref = new \ReflectionEnumUnitCase(self::class, $this->name);
        $attributes = $ref->getAttributes(Message::class);

        if (!isset($attributes[0])) {
            return '';
        }
        /**
         * @var Message $message
         */
        $message = ($attributes[0]->newInstance());
        return $message->getMessage();
    }

    /**
     * 获取状态码对应的http状态码
     * @return int
     * @date 2023/8/29 13:52
     * @author 原点 467490186@qq.com
     */
    public function getHttpCode(): int
    {
        $ref = new \ReflectionEnumUnitCase(self::class, $this->name);
        $attributes = $ref->getAttributes(Message::class);

        if (!isset($attributes[0])) {
            return 200;
        }
        /**
         * @var Message $message
         */
        $message = ($attributes[0]->newInstance());
        return $message->getHttpCode();
    }

}