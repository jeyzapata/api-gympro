<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Central
        $this->app->bind(\App\Repositories\Contracts\TenantRepositoryInterface::class, \App\Repositories\TenantRepository::class);

        // Admin/Billing
        $this->app->bind(\App\Repositories\Contracts\AdminUserRepositoryInterface::class, \App\Repositories\AdminUserRepository::class);
        $this->app->bind(\App\Repositories\Contracts\PlanPlataformaRepositoryInterface::class, \App\Repositories\PlanPlataformaRepository::class);
        $this->app->bind(\App\Repositories\Contracts\FacturaTenantRepositoryInterface::class, \App\Repositories\FacturaTenantRepository::class);
        $this->app->bind(\App\Repositories\Contracts\PagoPlataformaRepositoryInterface::class, \App\Repositories\PagoPlataformaRepository::class);

        // Core
        $this->app->bind(\App\Repositories\Contracts\SedeRepositoryInterface::class, \App\Repositories\SedeRepository::class);
        $this->app->bind(\App\Repositories\Contracts\EmpleadoRepositoryInterface::class, \App\Repositories\EmpleadoRepository::class);

        // Planes y Pricing
        $this->app->bind(\App\Repositories\Contracts\PlanRepositoryInterface::class, \App\Repositories\PlanRepository::class);
        $this->app->bind(\App\Repositories\Contracts\PlanPrecioRepositoryInterface::class, \App\Repositories\PlanPrecioRepository::class);
        $this->app->bind(\App\Repositories\Contracts\PlanBeneficioRepositoryInterface::class, \App\Repositories\PlanBeneficioRepository::class);
        $this->app->bind(\App\Repositories\Contracts\PromocionRepositoryInterface::class, \App\Repositories\PromocionRepository::class);

        // Socios y Membresías
        $this->app->bind(\App\Repositories\Contracts\SocioRepositoryInterface::class, \App\Repositories\SocioRepository::class);
        $this->app->bind(\App\Repositories\Contracts\MembresiaRepositoryInterface::class, \App\Repositories\MembresiaRepository::class);

        // Pagos y Caja
        $this->app->bind(\App\Repositories\Contracts\PagoRepositoryInterface::class, \App\Repositories\PagoRepository::class);
        $this->app->bind(\App\Repositories\Contracts\DeudaRepositoryInterface::class, \App\Repositories\DeudaRepository::class);
        $this->app->bind(\App\Repositories\Contracts\CajaRepositoryInterface::class, \App\Repositories\CajaRepository::class);
        $this->app->bind(\App\Repositories\Contracts\MetodoPagoRepositoryInterface::class, \App\Repositories\MetodoPagoRepository::class);
        $this->app->bind(\App\Repositories\Contracts\PagoItemRepositoryInterface::class, \App\Repositories\PagoItemRepository::class);
        $this->app->bind(\App\Repositories\Contracts\MovimientoCajaRepositoryInterface::class, \App\Repositories\MovimientoCajaRepository::class);

        // Clases y Turnos
        $this->app->bind(\App\Repositories\Contracts\ClaseRepositoryInterface::class, \App\Repositories\ClaseRepository::class);
        $this->app->bind(\App\Repositories\Contracts\TurnoClaseRepositoryInterface::class, \App\Repositories\TurnoClaseRepository::class);
        $this->app->bind(\App\Repositories\Contracts\ReservaRepositoryInterface::class, \App\Repositories\ReservaRepository::class);
        $this->app->bind(\App\Repositories\Contracts\AsistenciaRepositoryInterface::class, \App\Repositories\AsistenciaRepository::class);
        $this->app->bind(\App\Repositories\Contracts\TipoClaseRepositoryInterface::class, \App\Repositories\TipoClaseRepository::class);

        // Equipamiento
        $this->app->bind(\App\Repositories\Contracts\EquipoRepositoryInterface::class, \App\Repositories\EquipoRepository::class);
        $this->app->bind(\App\Repositories\Contracts\MantenimientoRepositoryInterface::class, \App\Repositories\MantenimientoRepository::class);
        $this->app->bind(\App\Repositories\Contracts\CategoriaEquipoRepositoryInterface::class, \App\Repositories\CategoriaEquipoRepository::class);

        // Nutrición
        $this->app->bind(\App\Repositories\Contracts\PlanNutricionalRepositoryInterface::class, \App\Repositories\PlanNutricionalRepository::class);
        $this->app->bind(\App\Repositories\Contracts\MedicionSocioRepositoryInterface::class, \App\Repositories\MedicionSocioRepository::class);
        $this->app->bind(\App\Repositories\Contracts\AlimentoRepositoryInterface::class, \App\Repositories\AlimentoRepository::class);
        $this->app->bind(\App\Repositories\Contracts\ComidaDiariaRepositoryInterface::class, \App\Repositories\ComidaDiariaRepository::class);
        $this->app->bind(\App\Repositories\Contracts\ComidaAlimentoRepositoryInterface::class, \App\Repositories\ComidaAlimentoRepository::class);

        // Usuarios
        $this->app->bind(\App\Repositories\Contracts\UserRepositoryInterface::class, \App\Repositories\UserRepository::class);
        $this->app->bind(\App\Repositories\Contracts\NotificacionRepositoryInterface::class, \App\Repositories\NotificacionRepository::class);
    }

    public function boot(): void
    {
        // Rate Limiters
        \Illuminate\Support\Facades\RateLimiter::for('login', function (\Illuminate\Http\Request $request) {
            $key = 'login|' . $request->ip() . '|' . strtolower($request->string('email')->toString());

            return \Illuminate\Cache\RateLimiting\Limit::perMinute(5)
                ->by($key)
                ->response(function () {
                    return response()->json([
                        'success' => false,
                        'message' => 'Demasiados intentos de login. Intentá de nuevo en un minuto.',
                    ], 429);
                });
        });

        \Illuminate\Support\Facades\RateLimiter::for('api', function (\Illuminate\Http\Request $request) {
            return \Illuminate\Cache\RateLimiting\Limit::perMinute(60)
                ->by($request->user()?->id ?: $request->ip())
                ->response(function () {
                    return response()->json([
                        'success' => false,
                        'message' => 'Límite de requests excedido. Máximo 60 por minuto.',
                    ], 429);
                });
        });

        \Dedoc\Scramble\Scramble::configure()
            ->withOperationTransformers(function (\Dedoc\Scramble\Support\Generator\Operation $operation) {
                // Solo agregar X-Tenant a rutas que NO son admin
                if (str_contains($operation->path ?? '', '/admin/')) {
                    return;
                }

                $type = (new \Dedoc\Scramble\Support\Generator\Types\StringType())->example('demo');
                $schema = \Dedoc\Scramble\Support\Generator\Schema::fromType($type);
                $parameter = new \Dedoc\Scramble\Support\Generator\Parameter('X-Tenant', 'header');
                $parameter->setSchema($schema);
                $parameter->description('Slug del tenant (ej: demo)');
                $parameter->required(true);
                $operation->addParameters([$parameter]);
            })
            ->withDocumentTransformers(function (\Dedoc\Scramble\Support\Generator\OpenApi $openApi) {
                $openApi->secure(
                    \Dedoc\Scramble\Support\Generator\SecurityScheme::http('bearer', 'JWT')
                );
            });
    }
}
