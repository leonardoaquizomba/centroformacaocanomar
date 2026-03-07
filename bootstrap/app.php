<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Global web rate limit — prevents brute-force against login forms and public endpoints.
        // 60 requests/minute per IP is generous for legitimate use but blocks automated attacks.
        $middleware->web(append: ['throttle:60,1']);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
