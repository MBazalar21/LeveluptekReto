<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Customize the response for unauthenticated users (e.g., missing Sanctum token).
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json(['message' => 'No autenticado.'], 401);
    }

    /**
     * Customize the response for validation exceptions.
     */
    protected function invalidJson($request, ValidationException $exception)
    {
        return response()->json([
            'message' => 'Error de validación.',
            'errors' => $exception->errors(),
        ], $exception->status);
    }

    /**
     * Customize general render logic (authorization, etc.)
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
            return response()->json([
                'message' => 'No tienes permiso para acceder a este recurso.',
            ], 403);
        }
    
        return parent::render($request, $exception);
    }
}