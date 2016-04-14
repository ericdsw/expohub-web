<?php

namespace ExpoHub\Http;

use ExpoHub\Http\Middleware\Authenticate;
use ExpoHub\Http\Middleware\CheckApiToken;
use ExpoHub\Http\Middleware\EncryptCookies;
use ExpoHub\Http\Middleware\RedirectIfAuthenticated;
use ExpoHub\Http\Middleware\VerifyCsrfToken;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Tymon\JWTAuth\Middleware\GetUserFromToken;
use Tymon\JWTAuth\Middleware\RefreshToken;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        CheckForMaintenanceMode::class,
        EncryptCookies::class,
        AddQueuedCookiesToResponse::class,
        StartSession::class,
        ShareErrorsFromSession::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => Authenticate::class,
        'auth.basic' => AuthenticateWithBasicAuth::class,
        'guest' => RedirectIfAuthenticated::class,
		'csrf.token' => VerifyCsrfToken::class,
		'jwt.auth' => GetUserFromToken::class,
		'jwt.refresh' => RefreshToken::class,
		'api.token' => CheckApiToken::class,
    ];
}
