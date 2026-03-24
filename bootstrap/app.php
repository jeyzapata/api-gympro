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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'tenant' => \App\Http\Middleware\InitializeTenancy::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Throwable $e, \Illuminate\Http\Request $request) {
            if ($request->expectsJson()) {
                return match(true) {
                    $e instanceof \App\Exceptions\Domain\DomainException
                        => response()->json(['success' => false, 'message' => $e->getMessage()], 422),

                    $e instanceof \Illuminate\Auth\AuthenticationException
                        => response()->json(['success' => false, 'message' => 'No autenticado.'], 401),

                    $e instanceof \Illuminate\Auth\Access\AuthorizationException
                        => response()->json(['success' => false, 'message' => 'Sin permisos.'], 403),

                    $e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException
                        => response()->json(['success' => false, 'message' => 'Recurso no encontrado.'], 404),

                    $e instanceof \Illuminate\Validation\ValidationException
                        => response()->json([
                            'success' => false,
                            'message' => 'Datos inválidos.',
                            'errors'  => $e->errors(),
                        ], 422),

                    default
                        => response()->json(['success' => false, 'message' => 'Error interno del servidor.'], 500),
                };
            }
            return null;
        });
    })->create();
