thinkPHP 6.0 脚手架

功能列表
===============
 + 钉钉日志通道
 + 统一异常处理
 + 统一状态码管理
 + 自动统一响应输出
 + 自动全局跨域处理
 + 异常钉钉消息通知（基于钉钉日志通道）
 + 环境配置文件自动加载

环境配置
===============
 + php7.1+
 + 框架thinkphp 6.0+
 + mysql 5.6+
 + URL重写 （nginx示例：）
      ```
     location / {
             index  index.php index.html index.htm;
             if (!-e $request_filename) {
                 rewrite  ^(.*)$  /index.php?s=$1  last;
                 break;
             }
          }
     ```
    [其他服务器配置](https://www.kancloud.cn/manual/thinkphp6_0/1037488)
  + 复制 项目根目录 ```.env-example```文件，重命名为 ```.env```
  + 根据.env文件注释，配置对应的内容（主要是数据库连接）
  
使用
===============
 + 项目根目录执行 
    + 【安装】composer install（ 部署服务器建议：composer install --no-dev）
    + 【升级】composer update 
 
 + 权限: ```项目跟目录/runtime``` 目录权限为777
  
说明
===============
 + 开启miss路由（强制路由，使用前先配置路由）
 + 错误码信息需统一在 `app\response` 目录处理
 + 环境配置
    - 主配置文件  `项目根目录\.env` 应用配置
    - 环境配置 切换  `项目根目录\.env`  `ENV_CONFIG = xx`
    - 环境配置文件  `项目根目录\config\dev`  `项目根目录\config\test`  `项目根目录\config\prod` 
 + 系统自动增加了全局跨域设置
    - 需要取消跨域设置进入 `app/middleware.php ` 文件，删除对应配置即可
     ```
         // 全局跨域处理
         \app\middleware\CrossDomain::class
     ```
 + 响应输出系统会自动统一格式处理(app\middleware\ResultMiddleware::class)，示例：
 ```
    // 控制器代码
    public function index()
     {
         return 'Welcome to v1 *****';
     }
     // 响应内容
     {"code":0,"message":"Success","data":"Welcome to v1 *****"}
     
     备注：响应数据类型为app\response\Result会自动获取对应类属性（无特殊情况，直接return数据即可）
 ```
 
 工具类
 ===============
 + 伪异步 `utils\async\AsyncHook`;
    - 应用结束时触发代码执行，基于`register_shutdown_function`实现

 备注
 ===============
 + [完全开发手册](https://www.kancloud.cn/manual/thinkphp6_0/content)
 
 ## 交流
 QQ交流群：1004068839

## 捐献
![](./public/images/wechat.png)
![](./public/images/alipay.png)