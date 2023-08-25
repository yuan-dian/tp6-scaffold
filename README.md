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

+ php8.1+
+ 框架thinkphp 6.1+
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

+ 权限: ```项目跟目录/runtime``` 目录权限为777 ，Linux命令示例： ``` chmod 777 runtime```

说明
===============

+ 开启miss路由（强制路由，使用前先配置路由）
+ 错误码信息需统一在 `app\exception\code` 目录处理
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
     // 响应内容(自动转换为app\response\Result对象)
     {"code":0,"message":"Success","data":"Welcome to v1 *****"}
     
     备注：响应数据类型为app\response\Result会自动获取对应类属性（无特殊情况，直接return数据即可）
 ```

+ 取消统一输出
    + 使用注解（PHP8+）
        ```
        use app\attribute\NoGlobalResponse;
        
        #[NoGlobalResponse]  // 注解在类上，该类的所有方法全部取消统一输出
        class Index
        {
            #[NoGlobalResponse] // 注解在方法上，当前方法取消统一输出
            public function index()
            {
                return 'Welcome to v1 *****';
            }
        }
        ``` 
    + 使用自定义函数
      ```
       public function index()
       {
           no_global_response(); // 在输出之前调用自定义函数
           return 'Welcome to v1 *****';
        }
       
      ```

+ 需要增加接口的请求和响应日志，只需要在路由配置增加上 `->append(['apiLog' => true])` 即可，示例：
   ```
    Route::get('index', ':version.Index/index')->append(['apiLog' => true]);
   ```

工具类
===============

+ 伪异步 `app\event\AsyncEvent`;
  /**
    * 注册需要执行的函数
    * @param callable $callback 回调方法
    * @param array $args 参数
      */
      AsyncEvent::register(callable $callback, array $args = []);
   ```

架构说明
===============

```
www WEB部署目录（或者子目录）
├─app 应用目录
│ ├─Annotation 注解目录
│ ├─controller 控制器目录
│ ├─event 事件目录
│ ├─model 模型目录
│ ├─exception 异常目录
│ ├─middleware 中间件目录
│ ├─service 服务目录（业务层）
│ ├─manager 可复用逻辑层目录
│ ├─utils 工具集目录
│ │
│ ├─ ... 更多自定义目录
│ │
│ ├─common.php 公共函数文件
│ └─event.php 事件定义文件
│
├─config 配置目录
│ ├─dev dev环境配置
│ ├─prod prod环境配置
│ ├─test test环境配置
│ │
│ ├─ ... 更多环境配置目录
│ │
│ ├─app.php 应用配置
│ ├─cache.php 缓存配置
│ ├─console.php 控制台配置
│ ├─cookie.php Cookie配置
│ ├─database.php 数据库配置
│ ├─filesystem.php 文件磁盘配置
│ ├─lang.php 多语言配置
│ ├─log.php 日志配置
│ ├─middleware.php 中间件配置
│ ├─route.php URL和路由配置
│ ├─session.php Session配置
│ ├─trace.php Trace配置
│ └─view.php 视图配置
│
├─view 视图目录
├─route 路由定义目录
│ ├─route.php 路由定义文件
│ └─ ...   
│
├─public WEB目录（对外访问目录）
│ ├─index.php 入口文件
│ ├─router.php 快速测试文件
│ └─.htaccess 用于apache的重写
│
├─extend 扩展类库目录
├─runtime 应用的运行时目录（可写，可定制）
├─vendor Composer类库目录
├─.example.env 环境变量示例文件
├─composer.json composer 定义文件
├─LICENSE.txt 授权说明文件
├─README.md README 文件
├─think 命令行入口文件
```

+ 调用流程 controller -> service -> manager -> model
+ Controller层：轻业务逻辑，参数校验，异常兜底。通常这种接口可以轻易更换接口类型，所以业务逻辑必须要轻，甚至不做具体逻辑
+ Service层：业务层，复用性较低，这里推荐每一个 controller 方法都得对应一个 service, 不要把业务编排放在 controller 中去做
+ Mannager层：可复用逻辑层，比如逻辑上的连表查询等，供Service层组合调用形成对应的业务逻辑
+ model层：数据库访问层。主要负责操作数据库的某张表

备注
===============

+ [完全开发手册](https://doc.thinkphp.cn/v8_0/preface.html)

## 交流

QQ交流群：1004068839

## 捐献

![](./public/images/wechat.png)
![](./public/images/alipay.png)