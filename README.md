thinkPHP 6.0 模板

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

环境配置
==============
 + 复制 项目根目录 ```.env-example```文件，重命名为 ```.env```
 + 根据.env文件注释，配置对应的内容（主要是数据库连接）

使用
===============
 + 项目根目录执行 composer install（安装） 或者 composer update （升级）
 + ```项目跟目录/runtime``` 目录权限为777
 
说明
===============
 + 开启miss路由（强制路由，使用前先配置路由）
 + 权限验证建议使用路由中间件
 
 
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
 ├─public           WEB目录（对外访问目录）
 │  ├─static             静态文件目录
 │  ├─index.php          入口文件
 │  ├─router.php         快速测试文件
 │  └─.htaccess          用于apache的重写
 ├─extend           扩展类库目录
 ```
 
 备注
 ===============
 + [完全开发手册](https://www.kancloud.cn/manual/thinkphp6_0/content)