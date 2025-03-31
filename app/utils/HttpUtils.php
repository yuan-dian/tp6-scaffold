<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | @copyright (c) http://www.auntec.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2025/3/31
// +----------------------------------------------------------------------

namespace app\utils;


use app\exception\code\CommonExceptionCode;
use app\exception\CommonException;
use think\facade\Log;

class HttpUtils
{
    private string $base_uri = '';
    private array $header = [];
    private bool $ssl = false;
    private bool $is_post = false;
    private string $router = '';
    // 请求get参数
    private array $get_params = [];
    // 请求post参数
    private array $post_params = [];
    // 超时时间
    private int $time_out = 3;

    private bool $is_json = true;

    public function __construct($config = [])
    {
        if (isset($config['base_uri'])) {
            $this->base_uri = $config['base_uri'];
        }
        if (isset($config['header'])) {
            $this->header = $config['header'];
        }
        if (isset($config['ssl'])) {
            $this->ssl = $config['ssl'];
        }
        if (isset($config['time_out'])) {
            $this->time_out = $config['time_out'];
        }
        if (isset($config['is_json'])) {
            $this->is_json = (bool)$config['is_json'];
        }
    }

    /**
     * 设备基础Url
     * @param string $base_uri
     * @return $this
     * @date 2025/3/31 17:22
     * @author 原点 467490186@qq.com
     */
    public function setBaseUri(string $base_uri): static
    {
        $this->base_uri = $base_uri;
        return $this;
    }

    /**
     * 设置header
     * @param array $header
     * @return $this
     * @date 2025/3/31 17:23
     * @author 原点 467490186@qq.com
     */
    public function setHeader(array $header): static
    {
        $this->header = $header;
        return $this;
    }

    /**
     * 是否开启ssl验证
     * @param bool $ssl
     * @return $this
     * @date 2025/3/31 17:23
     * @author 原点 467490186@qq.com
     */
    public function setSsl(bool $ssl): static
    {
        $this->ssl = $ssl;
        return $this;
    }

    /**
     * 设置过期时间
     * @param int $time_out
     * @return $this
     * @date 2025/3/31 17:23
     * @author 原点 467490186@qq.com
     */
    public function setTimeOut(int $time_out): static
    {
        $this->time_out = $time_out;
        return $this;
    }

    /**
     * @param bool $is_json
     * @return $this
     * @date 2025/3/31 17:24
     * @author 原点 467490186@qq.com设置是否是json请求
     */
    public function setIsJson(bool $is_json): static
    {
        $this->is_json = $is_json;
        return $this;
    }

    /**
     * get请求
     * @param string $router
     * @param array $request_params
     * @return string
     * @date 2020/5/20 15:31
     * @author 原点 467490186@qq.com
     */
    public function get(string $router, array $request_params): string
    {
        $this->router = $router;
        $this->get_params = $request_params;
        return $this->http_curl();
    }

    /**
     * post请求
     * @param string $router
     * @param array $post_params
     * @param array $get_params
     * @return mixed
     * @date 2022/11/28 15:54
     * @author 原点 467490186@qq.com
     */
    public function post(string $router, array $post_params = [], array $get_params = []): string
    {
        $this->is_post = true;
        $this->router = $router;
        $this->post_params = $post_params;
        $this->get_params = $get_params;
        return $this->http_curl();
    }


    /**
     * 发起请求
     * @return string
     * @date 2020/5/20 15:31
     * @author 原点 467490186@qq.com
     */
    private function http_curl(): string
    {
        $url = $this->base_uri . $this->router;
        if ($this->get_params) {
            $url .= '?' . http_build_query($this->get_params);
        }
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            if ($this->is_post) { //判断是否是POST请求
                curl_setopt($ch, CURLOPT_POST, 1);
                if ($this->is_json) {
                    // 使用json格式发送数据
                    $this->header = array_merge($this->header, ['Content-Type' => 'application/json']);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->post_params));
                } else {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->post_params));
                }
            }
            if ($this->header) {  //判断是否加header
                $headers = [];
                foreach ($this->header as $k => $v) {
                    $headers[] = $k . ':' . $v;
                }
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            }
            if (!$this->ssl) { //判断关闭开启ssl验证
                // 线下环境不用开启curl证书验证, 未调通情况可尝试添加该代码
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            }
            // 设置超时时间
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->time_out);

            $output = curl_exec($ch);
            curl_close($ch);
            if ($output === false) {
                $data = [
                    'url'    => $url,
                    'get'    => $this->get_params,
                    'post'   => $this->post_params,
                    'header' => $this->header,
                ];
                Log::error("三方接口请求失败：" . json_encode($data, JSON_UNESCAPED_UNICODE));
                throw new CommonException(CommonExceptionCode::THIRD_REQUEST_FAILED);
            }
            //打印获得的数据
            return $output;
        } catch (\Throwable $error) {
            $data = [
                'url'     => $url,
                'get'     => $this->get_params,
                'post'    => $this->post_params,
                'header'  => $this->header,
                'file'    => $error->getFile(),
                'line'    => $error->getLine(),
                'message' => $error->getMessage(),
                'code'    => $error->getCode(),
            ];
            Log::error("三方接口请求失败：" . json_encode($data, JSON_UNESCAPED_UNICODE));
            throw new CommonException(CommonExceptionCode::THIRD_REQUEST_FAILED);
        }
    }
}