<?php

namespace log\ding;

use bingher\ding\DingBot;
use think\contract\LogHandlerInterface;

/**
 * 钉钉日志驱动
 */
class DingLog implements LogHandlerInterface
{
    /**
     * 钉钉自定义机器人类
     * @var DingBot
     */
    protected $ding;
    /**
     * 配置信息
     * @var array
     */
    protected $config = [
        'enabled' => true,
        'webhook' => '',
        'at' => [],
        'secret' => '',
        'keyword' => '',
        'system_name' => '',
    ];

    public function __construct(array $config = [])
    {
        if (!empty($config)) {
            $this->config = array_merge($this->config, $config);
        }
        $this->ding = new DingBot($this->config);
    }

    /**
     * 日志消息保存
     * @param array $log 日志信息
     * @return [type]      [description]
     */
    public function save(array $log = []): bool
    {
        if ($this->config['enabled']) {
            $host = '';
            $uri = '';
            $message = '';
            $file = '';
            $line = '';
            $code = '';
            $query = '';
            $body = '';
            $app_id = '';
            $Authorization = '';
            $ip = '';
            foreach ($log as $type => $val) {
                foreach ($val as $msg) {
                    $host .= $msg['host'] . ',';
                    $uri .= $msg['uri'] . ',';
                    $message .= $msg['message'] . ',';
                    $file .= $msg['file'] . ',';
                    $line .= $msg['line'] . ',';
                    $code .= $msg['code'] . ',';
                    $query .= json_encode($msg['query']);
                    $body .= json_encode($msg['body']);
                    $app_id .= json_encode($msg['app_id']);
                    $Authorization .= json_encode($msg['Authorization']);
                    $ip .= $msg['ip'];
                }
            }

            $this->send($host, $uri, $message, $file, $line, $code, $query, $body, $app_id, $Authorization, $ip);
        }

        return true;
    }

    /**
     * 发送钉钉消息
     * @param $host
     * @param $uri
     * @param $message
     * @param $file
     * @param $line
     * @param $code
     * @param $query
     * @param $body
     * @param $app_id
     * @param $Authorization
     * @param $ip
     * @return bool
     * @date 2020/11/30 10:04
     * @author 原点 467490186@qq.com
     */
    protected function send($host, $uri, $message, $file, $line, $code, $query, $body, $app_id, $Authorization, $ip): bool
    {
        $msg = [
            trim($host, ','),
            trim($uri, ','),
            trim($message, ','),
            trim($code, ','),
            trim($file, ','),
            trim($line, ','),
            trim($query, ','),
            trim($body, ','),
            trim($app_id, ','),
            trim($Authorization, ','),
            trim($ip, ','),
        ];
        $env = env('env_config', 'prod'); //获取当前环境信息
        $system_name = $this->config['system_name'];  // 获取系统名称
        $msg_tpl = <<< tpl
【{$system_name}】
环境：{$env}
host：%s
uri：%s
错误信息：%s
错误码：%s
文件：%s
行号：%s
get参数：%s
post参数：%s
app_id：%s
Authorization：%s
IP：%s
tpl;
        $message = $message = vsprintf($msg_tpl, $msg);
        $res = $this->ding->at($this->config['at'])->text($message);
        return $res;
    }
}
