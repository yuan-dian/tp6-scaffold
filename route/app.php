<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use app\exception\code\CommonExceptionCode;
use app\exception\CommonException;
use think\facade\Route;

/*** 默认路由 */
Route::rule('/', function () {
    return 'Welcome to *****!';
});

/*** miss路由 */
Route::miss(function () {
    throw new CommonException(CommonExceptionCode::UNDEFINED_REQUEST);
}
);
// 路由配置增加->append(['apiLog' => true]) 就会开启记录接口的请求与响应日志

/*** 版本控制器路由 */
Route::group(':version', function () {
    Route::get('index', ':version.Index/index')->append(['apiLog' => true]);
})
    ->middleware('app\middleware\CheckSign');
