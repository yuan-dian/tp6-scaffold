<?php
// +----------------------------------------------------------------------
// | 加载环境配置
// +----------------------------------------------------------------------
// | Author: 原点 <467490186@qq.com>
// +----------------------------------------------------------------------
// | Date: 2019/9/16
// +----------------------------------------------------------------------

namespace app\event;

use think\facade\Config;
use think\facade\Env;

/**
 * 根据环境加载不同的配置
 * Class LoadConfig
 * @package app\behavior
 */
class LoadConfig
{
    public function handle()
    {
        $config_path = app()->getConfigPath(); //获取配置文件目录
        $env_config = Env::get('env_config', 'prod'); //获取当前环境信息
        $config_ext = app()->getConfigExt(); //获取配置后缀
        $dir = $config_path . $env_config . DIRECTORY_SEPARATOR;

        $files = isset($dir) ? scandir($dir) : [];

        foreach ($files as $file) {
            if ('.' . pathinfo($file, PATHINFO_EXTENSION) === $config_ext) {
                Config::load($dir . $file, pathinfo($file, PATHINFO_FILENAME));
            }
        }
    }
}