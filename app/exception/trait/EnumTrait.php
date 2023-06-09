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

    private function getData(): array
    {
        $ref = new \ReflectionEnumUnitCase(self::class, $this->name);
        $attributes = $ref->getAttributes(Message::class);

        if (!isset($attributes[0])) {
            return [];
        }
        /**
         * @var Message $message
         */
        $message = ($attributes[0]->newInstance());
        return $message->getDate();

    }

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