<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        // 检测应用是否进入维护模式
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,

        // 检测请求数据是否过大
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,

        // 对提交的请求参数进行 PHP 函数 ‘trim()’ 处理
        // \App\Http\Middleware\TrimStrings::class,

        // 将提交请求参数中空字符串转换为 null
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,

        // 修正代理服务器后的服务器参数
        // \App\Http\Middleware\TrustProxies::class
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            // Cookie 加密解密
            \App\Http\Middleware\EncryptCookies::class,
            // 将 Cookie 添加到响应中
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            // 开启会话
            \Illuminate\Session\Middleware\StartSession::class,
            // 将系统的错误数据注入到试图变量 $errors 中
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            // 检验 CSRF ，防止跨站请求伪造的安全威胁
            \App\Http\Middleware\VerifyCsrfToken::class,
            // 处理路由绑定
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            // 记录用户最后活跃时间
//            \App\Http\Middleware\RecordLastActivedTime::class
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * 中间件别名设置，允许你使用别名调用中间件，例如上面的 api 中间件组调用
     *
     * @var array
     */
    protected $routeMiddleware = [
        // 只有登录用户才能访问，我们在控制器的构造方法中大量使用
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        // HTTP Basic Auth 认证
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
         // 处理路由绑定
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        // 用户授权功能
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        // 只有游客才能访问，在 register 和 login 请求中使用，只有未登录用户才能访问这些页面
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        // 访问节流，类似于 『1 分钟只能请求 10 次』的需求，一般在 API 中使用
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        // 接口语言设置
        'change-locale' => \App\Http\Middleware\ChangeLocale::class
    ];
}
