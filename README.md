#Smart Score

A highly customizable data analysis web platform.

##使用说明

###Getting started

* 目录结构
    - app
        - Controller
            - HomeController.php
        - Model
            - UserModel.php
        - View
            - application.php
            - Home
                - default.php
                - partial.php
    - public
        - index.php

* 路径命名规范参考[psr-4](http://www.php-fig.org/psr/psr-4/)


```php
<?php

// 声明当前命名空间
namespace Smartscore;
// 初始化设置：autoloader等
require_once __DIR__."/init.php";

use SmartscoreFramework\Core\Bootstrap;
use SmartscoreFramework\Helper\Actions;

// 使用Bootstrap新建一个应用，第一个参数为namespace
// 第二个参数为应用设置，默认如下
// $confDefault = array(
//          'config'     => 'Config',
//          'controller' => 'Controller',
//          'model'      => 'Model',
//          'view'       => 'View',
//          'suffix'     => array(
//               根据名字自动生成对应的类名所使用的后缀
//               如资源名为User，则其控制器为UserController，模型为UserModel，视图为UserView
//              'controller' => 'Controller',
//              'model'      => 'Model',
//              'view'       => 'View'
//          )
//      );
$app = Bootstrap::createApplication('Smartscore');

// 获取application的Router，用来注册路由
$r   = $app->getRouter();

// 注册命名路由。第一个参数为url，第二个参数为映射的控制器及其方法
// url中以'：'开头的是url参数，会被解析到对应controller方法中的$params参数（第二个参数）
// 映射string的格式为： 控制器:方法后缀
// 控制器即处理该HTTP请求的控制器名，此例中为HomeController
// 方法后缀即调用控制器中的方法的后缀，其与HTTP动作组合成完整的方法名
// 此例中，若HTTP GET，则为get_test，POST则为post_test
// 若不提供方法后缀，即只有'Home'，则默认方法后缀为'default'
$r->register('/home/:page', 'Home:test');

// 所有配置完成后运行app
$app->run();
```

* Controller参数说明

控制器中方法的参数共有两个，第一个为`$app`，即当前`application`上下文，可从中获取各种设置
第二个为`$params`，为`url`参数及`QueryString`参数的合集，可从中获取请求参数
        
```php
<?php
class HomeController {
    public function get_test($app, $params) { ... }
}
```

* View Render

在`controller`中调用`$this->setView`方法，可以设置`Main View`及`Partial View`的名称，框架会自动寻找其真实路径。
在`view`中可调用`$this->__yield($partial_name)`来渲染特定的`Partial View`。

* Redirection 重定向

重定向的`Helper`为`SmartscoreFramework\Helper\Actions::redirect`，其函数签名为：
```php
public static function redirect($target, $status = 302)
```
`$target`为想要重定向到的`url`，`$status`为重定向的`HTTP CODE`，一般为`302`或`303`