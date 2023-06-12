<?php
// +----------------------------------------------------------------------
// | 伪异步处理类
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2020/6/16
// +----------------------------------------------------------------------
namespace app\event;

use think\facade\Log;

/**
 * 进程关闭hook执行
 * 使用场景
 *      有异步执行的需要且不需要返回信息 如：发送通知（短信、邮件、钉钉等）
 * 使用方法：在需要异步处理的地方使用 AsyncEvent::register(); 注册需要异步执行的回调方法
 *      示例：AsyncEvent::register(['app\\Async','test'],['b']);
 */
class AsyncEvent
{
    private static array $hook_list = array();

    /**
     * 注册需要执行的函数
     * @param callable $callback 回调方法
     * @param array $args 参数
     * @date 2020/6/17 13:51
     * @author 原点 467490186@qq.com
     */
    public static function register(callable $callback, array $args = []): void
    {
        self::$hook_list[] = array('callback' => $callback, 'args' => $args);
    }

    /**
     * handle
     * @date 2020/6/17 15:33
     * @author 原点 467490186@qq.com
     */
    public function handle(): void
    {
        if (empty(self::$hook_list)) {
            return;
        }
        foreach (self::$hook_list as $hook) {
            try {
                call_user_func_array($hook['callback'], $hook['args']);
            } catch (\Throwable $e) {
                Log::write($e, 'error');
            }
        }

    }
}