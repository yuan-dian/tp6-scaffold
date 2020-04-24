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

namespace app\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;

class Test extends Command
{
    /**
     * 配置指令
     * @date 2020/4/24 13:34
     * @author 原点 467490186@qq.com
     */
    protected function configure()
    {
        $this->setName('test')->setDescription('Command Test');
    }

    /**
     * 执行方法
     * @param Input $input
     * @param Output $output
     * @return int|void|null
     * @date 2020/4/24 13:34
     * @author 原点 467490186@qq.com
     */
    protected function execute(Input $input, Output $output)
    {
        $output->writeln("TestCommand:");
    }

}