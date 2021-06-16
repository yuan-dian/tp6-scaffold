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
use think\facade\Route;

/*** 默认路由 */
Route::rule('/', function () {
    return 'Welcome to *****!';
});

/*** miss路由 */
Route::miss(function () {
        throw new \app\exception\BusinessException(\app\constants\ErrorCode::NO_REQUEST);
    }
);
/*** 版本控制器路由 */
Route::group(':version', function () {
    Route::get('index', ':version.Index/index');
})
    ->middleware('app\middleware\CheckSign');;
