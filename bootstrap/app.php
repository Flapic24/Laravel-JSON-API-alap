<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Support\ApiResponse;
use Throwable;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        api: __DIR__.'/../routes/api.php',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (ValidationException $e) {
            return ApiResponse::error(
                code: 'VALIDATION_ERROR',
                message: 'Invalid request data',
                details: $e->errors(),
                status: 422
            );
        });
        $exceptions->render(function (NotFoundHttpException $e) {
            return ApiResponse::error(
                code: 'NOT_FOUND',
                message: 'Route not found',
                details: null,
                status: 404
            );
        });
        $exceptions->render(function (Throwable $e) {
            return ApiResponse::error(
                code: 'INTERNAL_ERROR',
                message: 'Internal server error',
                details: null,
                status: 500
            );
        });
    })->create();
