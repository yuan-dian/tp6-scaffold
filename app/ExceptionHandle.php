<?php
namespace app;

use app\exception\BusinessException;
use app\response\Result;
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
 * 应用异常处理类
 */
class ExceptionHandle extends Handle
{
    /**
     * @var int http 状态码
     */
    public $httpCode = 500;
    /**
     * 不需要记录信息（日志）的异常类列表
     * @var array
     */
    protected $ignoreReport = [
        HttpException::class,
        HttpResponseException::class,
        ModelNotFoundException::class,
        DataNotFoundException::class,
        ValidateException::class,
        BusinessException::class,
    ];

    /**
     * 记录异常信息（包括日志或者其它方式记录）
     *
     * @access public
     * @param  Throwable $exception
     * @return void
     */
    public function report(Throwable $exception): void
    {
        if (!$this->isIgnoreReport($exception)) {
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
                'trace' => explode('#4', $exception->getTraceAsString())[0],
                // get 参数
                'GET' => Request::get(),
                // post参数
                'POST' => Request::post(),
                // header 头信息
                'header' => Request::header(),
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
     * @return Result|Response
     * @date 2021/6/16 14:20
     * @author 原点 467490186@qq.com
     */
    public function render($request, Throwable $e) :Response
    {
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

        // 服务器错误，正式环境统一输出错误信息，防止服务器信息敏感信息被输出
        if ($this->httpCode == 500 && env('env_config', 'prod') == 'prod' && !($e instanceof BusinessException)) {
            $message = '服务异常请重试';
        }

        if (true == Env::get('app_debug', false) && $this->httpCode == 500) {
            return parent::render($request, $e);
        }
        return response((new Result())->setCode($this->getCode($e))->setMessage($message)->setHttpCode($this->httpCode));
    }
}
