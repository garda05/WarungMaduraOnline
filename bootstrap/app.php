<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // Alias middleware role
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);

        // FIX CSRF (LARAVEL 11 / 12 WAY)
        $middleware->validateCsrfTokens(except: [
            'login',
            'logout',
            'chat/send',
            'keranjang/*',
            'pesanan/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
