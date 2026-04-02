<?php

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (ModelNotFoundException $e, Request $request) {
            return response()->json([
                'status' => false,
                'message' => 'Record Not Found',
            ], 404);
        });

        $exceptions->render(function (AuthorizationException $e, Request $request) {
            return response()->json([
                'status' => false,
                'message' => 'You are not authorized for this action'
            ], 403);
        });

        $exceptions->render(function (AuthenticationException $e, Request $request) {
            return response()->json([
                'status' => false,
                'message' => 'Please login to continue'
            ], 401);
        });

        $exceptions->render(function (ValidationException $e, Request $request) {
            return response()->json([
                'status' => false,
                'message' => 'validation failed',
                'errors' => $e->errors()
            ], 422);
        });

        $exceptions->render(function (Exception $e, Request $request) {
            return response()->json([
                'status' => false,
                'message' => 'Somthing went wrong',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        });
    })->create();
