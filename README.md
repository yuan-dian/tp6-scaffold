thinkPHP 6.0 脚手架

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

使用
===============
 + 项目根目录执行 
    + 【安装】composer install（ 部署服务器建议：composer install --no-dev）
    + 【升级】composer update 
 
 + 权限: ```项目跟目录/runtime``` 目录权限为777
 
 环境配置
 ==============
  + 复制 项目根目录 ```.env-example```文件，重命名为 ```.env```
  + 根据.env文件注释，配置对应的内容（主要是数据库连接）
  
说明
===============
 + 开启miss路由（强制路由，使用前先配置路由）
 + 权限验证建议使用路由中间件
 + 错误码信息需统一在 `app\response` 目录处理
 + 响应输出系统会自动统一格式处理，示例：
 ```
    // 控制器代码
    public function index()
     {
         return 'Welcome to v1 *****';
     }
     // 响应内容【备注：若响应内容包含code属性，不会自动格式化】
     {"code":0,"message":"Success","data":"Welcome to v1 *****"}
 ```
 
 
目录说明
===============
```
 ├─app          应用目录
 │  ├─command           自定义命令行（cli模式）
 │  ├─constant          常量定义
 │  ├─controller        控制器目录
 │  │  ├─v1                 控制器版本目录
 │  │  └─ ...               更多版本目录
 │  ├─event             事件目录
 │  ├─exception         异常处理目录
 │  ├─middleware        中间件目录
 │  ├─model             模型目录
 │  ├─service           服务目录 
 │  ├─validate          验证器目录
 ├─config       配置
 │  ├─dev           dev环境配置目录
 │  │  └─ ...           dev配置文件
 │  ├─prod          prod环境配置目录
 │  │  └─ ...           prod配置文件
 │  ├─test          test环境配置目录
 │  │  └─ ...           test配置文件
 │  └─ ...          其他或框架配置文件
 ├─public       WEB目录（对外访问目录）
 │  ├─static             静态文件目录
 │  ├─index.php          入口文件
 │  ├─router.php         快速测试文件
 │  └─.htaccess          用于apache的重写
 ├─extend           扩展类库目录
 ```
 
 备注
 ===============
 + [完全开发手册](https://www.kancloud.cn/manual/thinkphp6_0/content)
 
 ## 交流
 QQ交流群：1004068839
  
 ## 捐献
 ![](http://blog.zhuangjun.top/images/wx_reward.png) 
 ![](http://blog.zhuangjun.top/images/ali_reward.png)