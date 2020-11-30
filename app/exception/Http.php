<?php
// +----------------------------------------------------------------------
// |
// +----------------------------------------------------------------------
// | @copyright (c) http://www.auntec.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2020/4/24
// +----------------------------------------------------------------------

namespace app\exception;

use Exception;

use think\exception\Handle;
use think\exception\ValidateException;
use think\facade\Request;
use think\Response;
use Throwable;

/**
 * 自定义异常处理
 * Class ApiHandleException
 * @package app\exception
 */
class Http extends Handle
{
    /**
     * @var int http 状态码
     */
    public $httpCode = 500;

    public function render($request, Throwable $e): Response
    {
        if (true == env('app_debug', 'false')) {
            return parent::render($e);
        }
        $message = $this->getMessage($e);
        // 参数验证错误
        if ($e instanceof ValidateException) {
            $message = $e->getError();
            $this->httpCode = 422;
        }
        // 其他自定义错误处理


        // 服务器错误，正式环境统一输出错误信息，防止服务器信息敏感信息被输出
        if ($this->httpCode == 500 && env('env_config', 'prod') == 'prod') {
            $message = '服务异常请重试';
        }

        return format_response([], $this->getCode($e), $message, $this->httpCode);
    }

    /**
     * Report or log an exception.
     *
     * @access public
     * @param Throwable $exception
     * @return void
     */
    public function report(Throwable $exception): void
    {
        $data = [];
        if (!$this->isIgnoreReport($exception)) {
            // 收集异常数据
            $data = [
                'host' => Request::host(),
                'uri' => Request::url(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'message' => $this->getMessage($exception),
                'code' => $this->getCode($exception),
                'query' => Request::get(),
                'body' => Request::post(),
                'app_id' => Request::header('appId', ''),
                'Authorization' => Request::header('Authorization', ''),
                'ip' => Request::ip(),
            ];
        }
        try {
            $this->app->log->record($data, 'error');
        } catch (Exception $e) {
        }
    }

}