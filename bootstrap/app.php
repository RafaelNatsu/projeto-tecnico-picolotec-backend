<?php

use Http\Client\Exception\HttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // $middleware->statefulApi();
        $middleware->api(append:[
            App\Http\Middleware\JsonResponse::class,
            App\Http\Middleware\JsonPayload::class,
        ]);
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Exception $e, $request) {
        if ($request->is('api/*')) {
            $statusCode = match (true) {
                $e instanceof ValidationException => 422,
                $e instanceof ModelNotFoundException => 404,
                $e instanceof AuthenticationException => 401,
                $e instanceof HttpException => $e->getCode(),
                default => (int) $e->getCode() ?: 500,
            };
            return (new \App\Http\Resources\ErrorResource([
                'message' => $e->getMessage(),
                'code'    => $statusCode
            ]))->response()->setStatusCode($statusCode);
        }
    });
    })->create();
