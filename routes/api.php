<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Central routes (public schema — no tenant context needed)
|--------------------------------------------------------------------------
*/
Route::prefix('v1')->group(function () {
    Route::apiResource('tenants', \App\Http\Controllers\Api\V1\TenantController::class)
        ->only(['index', 'show']);
});

/*
|--------------------------------------------------------------------------
| Auth routes (require tenant context but NOT authentication)
|--------------------------------------------------------------------------
|
| Login needs the tenant schema set so Sanctum can find the user,
| but the user is not yet authenticated at this point.
|
*/
Route::prefix('v1/auth')->middleware('tenant')->group(function () {
    Route::post('login', [\App\Http\Controllers\Api\V1\AuthController::class, 'login'])
        ->middleware('throttle:login');
});

Route::prefix('v1/auth')->middleware(['tenant', 'auth:sanctum'])->group(function () {
    Route::get('me', [\App\Http\Controllers\Api\V1\AuthController::class, 'me']);
    Route::post('logout', [\App\Http\Controllers\Api\V1\AuthController::class, 'logout']);
});

/*
|--------------------------------------------------------------------------
| Tenant routes (require X-Tenant header + authentication)
|--------------------------------------------------------------------------
|
| The 'tenant' middleware MUST run before 'auth:sanctum' because
| the users table lives inside the tenant schema.
|
*/
Route::prefix('v1')->middleware(['tenant', 'auth:sanctum', 'throttle:api'])->group(function () {
    // Core
    Route::apiResource('sedes', \App\Http\Controllers\Api\V1\SedeController::class);
    Route::apiResource('empleados', \App\Http\Controllers\Api\V1\EmpleadoController::class);

    // Planes y Pricing
    Route::apiResource('planes', \App\Http\Controllers\Api\V1\PlanController::class);
    Route::apiResource('plan-precios', \App\Http\Controllers\Api\V1\PlanPrecioController::class);
    Route::apiResource('plan-beneficios', \App\Http\Controllers\Api\V1\PlanBeneficioController::class);
    Route::apiResource('promociones', \App\Http\Controllers\Api\V1\PromocionController::class);

    // Socios y Membresias
    Route::apiResource('socios', \App\Http\Controllers\Api\V1\SocioController::class);
    Route::apiResource('membresias', \App\Http\Controllers\Api\V1\MembresiaController::class);

    // Pagos y Caja
    Route::apiResource('pagos', \App\Http\Controllers\Api\V1\PagoController::class);
    Route::apiResource('deudas', \App\Http\Controllers\Api\V1\DeudaController::class);
    Route::apiResource('cajas', \App\Http\Controllers\Api\V1\CajaController::class);

    // Clases y Turnos
    Route::apiResource('clases', \App\Http\Controllers\Api\V1\ClaseController::class);
    Route::apiResource('turno-clases', \App\Http\Controllers\Api\V1\TurnoClaseController::class);
    Route::apiResource('reservas', \App\Http\Controllers\Api\V1\ReservaController::class);
    Route::apiResource('asistencias', \App\Http\Controllers\Api\V1\AsistenciaController::class);

    // Equipamiento
    Route::apiResource('equipos', \App\Http\Controllers\Api\V1\EquipoController::class);
    Route::apiResource('mantenimientos', \App\Http\Controllers\Api\V1\MantenimientoController::class);

    // Nutricion
    Route::apiResource('plan-nutricionales', \App\Http\Controllers\Api\V1\PlanNutricionalController::class);
    Route::apiResource('medicion-socios', \App\Http\Controllers\Api\V1\MedicionSocioController::class);

    // Notificaciones
    Route::apiResource('notificaciones', \App\Http\Controllers\Api\V1\NotificacionController::class);
});
