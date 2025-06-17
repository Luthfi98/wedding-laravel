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
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e, $request) {
            return $request->expectsJson()
                ? response()->json(['message' => $e->getMessage()], 401)
                : redirect()->guest(route('login'))
                    ->with('error', 'You need to login first to access that page.');
        });
        $exceptions->render(function (\Spatie\Permission\Exceptions\UnauthorizedException $e, $request) {
            if (!$request->expectsJson()) {
                if (auth()->check()) {
                    return response()->view('errors.unauthorized', ['title' => 'Unauthorized'], 403);
                }
            }

            return response()->json([
                'responseMessage' => 'You do not have the required authorization.',
                'responseStatus'  => 403,
            ]);
        });
    })->create();
