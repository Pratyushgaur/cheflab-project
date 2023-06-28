<?php

namespace App\Http;

use App\Http\Middleware\ApiLogMiddelware;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

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
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            EnsureFrontendRequestsAreStateful::class,
//            'throttle:api',//https://startutorial.com/view/fixing-429-too-many-requests-in-laravel
            'throttle:600,1',//You can delete this middleware or change limits. In the first parameter, set the maximum number of requests per minute to be processed. The second parameter should include the number of minutes you need to wait before completing other requests when the limit of requests from the first parameter is exceeded.
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            ApiLogMiddelware::class,
        ],
        'isAdmin' => [
            \App\Http\Middleware\isAdmin::class,
        ],

        'isVendor' => [
            \App\Http\Middleware\isVendor::class,
        ],
        'isAppVendor' => [
            \App\Http\Middleware\isAppVendor::class,
        ],
        'isChef' => [
            \App\Http\Middleware\isChef::class,
        ],
        'isRestaurant' => [
            \App\Http\Middleware\isRestaurant::class,
        ],
        'isAppRestaurant' => [
            \App\Http\Middleware\isAppRestaurant::class,
        ],
        'IsAppVendorDoneSettingsMiddleware' => [
            \App\Http\Middleware\IsAppVendorDoneSettingsMiddleware::class,
        ],
        'IsVendorDoneSettingsMiddleware' => [
            \App\Http\Middleware\IsVendorDoneSettingsMiddleware::class,
        ],
        'isChefRestaurant' => [
            \App\Http\Middleware\isChefRestaurant::class,
        ],

    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'isadminloginAuth' => \App\Http\Middleware\isAdminLoginAuth::class,
        'isVendorloginAuth' => \App\Http\Middleware\isVendorLoginAuth::class,
        'isChefLoginAuth' => \App\Http\Middleware\isChefLoginAuth::class,
//        'ApiLogMiddelware'=>\Illuminate\Routing\Middleware\ApiLogMiddelware::class,
    ];
}
