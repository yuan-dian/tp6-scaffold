<?php

namespace app;

use app\exception\code\CommonExceptionCode;
use app\exception\ServiceException;
use app\response\Result;
use think\db\exception\PDOException;
use think\exception\Handle;
use think\exception\ValidateException;
use think\facade\Env;
use think\facade\Request;
use think\Response;
use Throwable;

/**
 * 应用异常处理类
 */
class ExceptionHandle extends Handle
{
    /**
     * @var int http 状态码
     *
     */
    protected int $httpCode = 500;

    /**
     * 记录异常信息（包括日志或者其它方式记录）
     *
     * @access public
     * @param Throwable $exception
     * @return void
     */
    public function report(Throwable $exception): void
    {
        if (!$this->isIgnoreReport($exception)) {
            $header = Request::header();
            unset($header['cookie'], $header['accept'], $header['host'], $header['connection']);
            // 收集异常数据
            $data = [
                // uri
                'uri' => Request::url(true),
                // 错误码
                'code' => $this->getCode($exception),
                // 错误信息
                'message' => $this->getMessage($exception),
                // 错误文件
                'file' => $exception->getFile(),
                // 错误行号
                'line' => $exception->getLine(),
                // 错误堆栈
                'trace' => explode('#5', $exception->getTraceAsString())[0],
                // get 参数
                'GET' => Request::get(),
                // post参数
                'POST' => Request::post() ?: Request::getInput(),
                // header 头信息
                'header' => $header,
                // 访问ip
                'ip' => Request::ip(),
            ];
            try {
                $this->app->log->record($data, 'error');
            } catch (Throwable $e) {
                parent::report($e);
            }
        }
    }

    /**
     * @param \think\Request $request
     * @param Throwable $e
     * @return Response
     * @date 2021/6/16 14:20
     * @author 原点 467490186@qq.com
     */
    public function render($request, Throwable $e): Response
    {
        $message = $this->getMessage($e);
        // 未知异常
        $code = CommonExceptionCode::DEFAULT_FAIL->value;
        // 参数验证错误
        if ($e instanceof ValidateException) {
            $message = $e->getError();
            $code = CommonExceptionCode::PARAM_ERROR->value;
            $this->httpCode = 400;
        }
        // 判断是否为自定义错误类型
        if ($e instanceof ServiceException) {
            $code = $this->getCode($e);
            $this->httpCode = (int)$e->getHttpCode();
        }
        // PDO异常
        if ($e instanceof PDOException) {
            $code = CommonExceptionCode::MYSQL_ERROR->value;
            $message = CommonExceptionCode::MYSQL_ERROR->getMessage();
        }

        // 服务器错误，正式环境统一输出错误信息，防止服务器信息敏感信息被输出
        if ($this->httpCode == 500 && env('env_config', 'prod') == 'prod' && !($e instanceof ServiceException)) {
            $message = '服务异常请重试';
        }

        if (Env::get('app_debug', false) && $this->httpCode == 500) {
            no_global_response();
            return parent::render($request, $e);
        }
        return response((new Result())->setCode($code)->setMessage($message)->setHttpCode($this->httpCode));
    }

    protected function isIgnoreReport(Throwable $exception): bool
    {
        // 自定义异常且状态码为500时需要记录日志
        if ($exception instanceof ServiceException) {
            if ($exception->getHttpCode() == 500) {
                return false;
            }
            return true;
        }
        return parent::isIgnoreReport($exception);
    }
}
