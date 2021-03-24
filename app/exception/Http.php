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

use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\Handle;
use think\exception\HttpException;
use think\exception\HttpResponseException;
use think\exception\ValidateException;
use think\facade\Env;
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

    protected $ignoreReport = [
        HttpException::class,
        HttpResponseException::class,
        ModelNotFoundException::class,
        DataNotFoundException::class,
        ValidateException::class,
        BusinessException::class,
    ];

    public function render($request, Throwable $e): Response
    {
        if (true == env('app_debug', 'false')) {
            return parent::render($request, $e);
        }
        $message = $this->getMessage($e);
        // 参数验证错误
        if ($e instanceof ValidateException) {
            $message = $e->getError();
            $this->httpCode = 422;
        }
        // 判断是否为自定义错误类型
        if ($e instanceof BusinessException) {
            $this->httpCode = (int)$e->httpCode;
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
                // uri
                'uri' => Request::host()  . Request::url(),
                // 错误码
                'code' => $this->getCode($exception),
                // 错误信息
                'message' => $this->getMessage($exception),
                // 错误文件
                'file' => $exception->getFile(),
                // 错误行号
                'line' => $exception->getLine(),
                // 错误堆栈
                'trace' => substr($exception->getTraceAsString(), 0, 300),
                // get 参数
                'GET' => Request::get(),
                // post参数
                'POST' => Request::post(),
                // header 头信息
                'header' => Request::header(),
                // 访问ip
                'ip' => Request::ip(),
            ];
        }
        try {
            $this->app->log->record($data, 'error');
        } catch (Exception $e) {
        }
    }

}