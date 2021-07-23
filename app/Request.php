<?php
namespace app;

// 应用请求对象类
class Request extends \think\Request
{
    protected $proxyServerIp = ['0.0.0.0'];
    /**
     * 获取客户端IP地址 （重写方法，去除代理ip校验）
     * @access public
     * @return string
     */
    public function ip(): string
    {
        if (!empty($this->realIP)) {
            return $this->realIP;
        }

        $this->realIP = $this->server('REMOTE_ADDR', '');

        // 如果指定了前端代理服务器IP以及其会发送的IP头
        // 则尝试获取前端代理服务器发送过来的真实IP
        $proxyIp       = $this->proxyServerIp;
        $proxyIpHeader = $this->proxyServerIpHeader;

        $tempIP = '';
        if (count($proxyIp) > 0 && count($proxyIpHeader) > 0) {
            // 从指定的HTTP头中依次尝试获取IP地址
            // 直到获取到一个合法的IP地址
            foreach ($proxyIpHeader as $header) {
                $tempIP = $this->server($header);
                if (empty($tempIP)) {
                    continue;
                }

                $tempIP = trim(explode(',', $tempIP)[0]);

                if (!$this->isValidIP($tempIP)) {
                    $tempIP = null;
                } else {
                    break;
                }
            }
            $this->realIP = $tempIP;
        }
        if (!$this->isValidIP($this->realIP)) {
            $this->realIP = '0.0.0.0';
        }

        return $this->realIP;
    }

}
