<?php

use App\Http\Middleware\LogRequest;
use App\Http\Middleware\LogResponse;
use App\Http\Middleware\ValidateRtmToken;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
        $middleware->append(LogRequest::class);
        $middleware->append(LogResponse::class);
        $middleware->alias(['validate.rtm.token' => ValidateRtmToken::class]);
        $middleware->group('api', [
            EnsureFrontendRequestsAreStateful::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
