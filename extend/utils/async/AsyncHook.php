<?php
// +----------------------------------------------------------------------
// | 伪异步处理类
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2020/6/16
// +----------------------------------------------------------------------
namespace utils\async;

/**
 * 进程关闭hook执行
 * 使用场景
 *      有异步执行的需要且不需要返回信息 如：发送通知（短信、邮件、钉钉等）
 * 使用方法：在需要异步处理的地方使用 AsyncHook::register(); 注册需要异步执行的回调方法
 *      示例：AsyncHook::register(['app\\Async','test'],['b']);
 */
class AsyncHook
{
    private static $hook_list = array();
    private static $hooked = false;

    /**
     * 注册需要执行的函数
     * @param array $callback 回调方法
     * @param array $params   参数
     * @date 2020/6/17 13:51
     * @author 原点 467490186@qq.com
     */
    public static function register(array $callback, $params = [])
    {
        self::$hook_list[] = array('callback' => $callback, 'params' => $params);
    }

    /**
     * handle 函数注册fastcgi_finish_request
     * @date 2020/6/17 15:33
     * @author 原点 467490186@qq.com
     */
    public function handle()
    {
        try {
            if (self::$hooked == false && self::$hook_list) {
                self::$hooked = true;
                register_shutdown_function(array(__CLASS__, '__hook'));
            }
        } catch (\Exception $e) {
            // 注册回调失败
            // 记录日志
            // 发送通知

        }

    }

    /**
     * 由系统调用
     * @date 2020/6/17 15:33
     * @author 原点 467490186@qq.com
     */
    public static function __hook()
    {
        if (!function_exists('fastcgi_finish_request')) {
            // 提高页面响应
            header('Content-Length: ' . ob_get_length());  //告诉浏览器数据长度,浏览器接收到此长度数据后就不再接收数据
            header("Connection: Close");      //告诉浏览器关闭当前连接,即为短连接
            ob_flush();
            flush();
        }
        if (empty(self::$hook_list)) {
            return;
        }
        foreach (self::$hook_list as $hook) {
            try {
                $callback = $hook['callback'];
                $params = $hook['params'];
                call_user_func_array($callback, $params);
            } catch (\Exception $e) {
                // 回调失败
                // 记录日志
                // 发送通知
            }
        }
    }
}