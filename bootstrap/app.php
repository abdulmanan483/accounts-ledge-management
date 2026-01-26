<?php

use App\Exceptions\PermissionDeniedException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
// use Illuminate\Http\Client\Request;
use Illuminate\Http\Request;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware(['web', 'auth'])
                ->prefix('admin')
                ->group(base_path('routes/admin.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
            return $request->is('api/*') || $request->expectsJson();
        });
        $exceptions->renderable(function (Throwable $e, Request $request) {
            // Always respond with JSON if it's an API route or expects JSON (header)
            if ($request->expectsJson() || $request->is('api/*')) {
                if (!auth()->check()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Unauthenticated',
                    ], 401);
                }

                return response()->json([
                    'status' => false,
                    'message' => $e->getMessage(),
                    'exception' => get_class($e),
                ], 500);
            }

            // Else: return normal Laravel exception (HTML)
        });
    })
    ->create();
