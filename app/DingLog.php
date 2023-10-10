<?php

namespace app;

use bingher\ding\DingBot;
use think\contract\LogHandlerInterface;
use think\facade\Lang;
use think\facade\Log;

/**
 * 钉钉日志驱动
 */
class DingLog implements LogHandlerInterface
{
    /**
     * 钉钉自定义机器人类
     * @var DingBot
     */
    protected DingBot $ding;
    /**
     * 配置信息
     * @var array
     */
    protected array $config = [
        'enabled'     => true,
        'webhook'     => '',
        'at'          => [],
        'secret'      => '',
        'keyword'     => '',
        'system_name' => '',
    ];

    public function __construct(array $config = [])
    {
        if (!empty($config)) {
            $this->config = array_merge($this->config, $config);
        }
        try {
            $this->ding = new DingBot($this->config);
        } catch (\Exception $e) {
            Log::info($e);
        }
    }

    /**
     * 日志消息保存
     * @param array $log
     * @return bool
     * @date 2021/1/25 18:00
     * @author 原点 467490186@qq.com
     */
    public function save(array $log = []): bool
    {
        if ($this->config['enabled'] && !env('app_debug', false) && isset($log['error'][0])) {
            $message = [
                'system_name' => $this->config['system_name'],
                'env'         => env('env_config', 'prod'),
            ];
            $message = array_merge($message, $log['error'][0]);
            $msg = '';
            foreach ($message as $key => $value) {
                $msg .= Lang::get($key) . '：' . (is_string($value) ? $value : json_encode(
                        $value,
                        JSON_UNESCAPED_UNICODE
                    )) . "\r\n";
            }

            $this->ding->at($this->config['at'])->text(trim($msg));
        }
        return true;
    }
}
