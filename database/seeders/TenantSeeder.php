<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\CategoriaEquipo;
use App\Models\Empleado;
use App\Models\MetodoPago;
use App\Models\Plan;
use App\Models\PlanPrecio;
use App\Models\Rol;
use App\Models\Sede;
use App\Models\Tenant;
use App\Models\TipoClase;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create tenant in public schema.
        //    TenancyServiceProvider listens to TenantCreated and runs:
        //    CreateDatabase (creates PG schema) + MigrateDatabase (runs tenant migrations).
        $tenant = Tenant::create([
            'slug'               => 'demo',
            'nombre'             => 'Gimnasio Demo',
            'email_admin'        => 'admin@gymdemo.com',
            'telefono'           => '+54 11 1234-5678',
            'schema_name'        => 'gym_demo',
            'plan_suscripcion'   => 'pro',
            'suscripcion_activa' => true,
            'max_sedes'          => 3,
            'max_empleados'      => 50,
            'max_socios'         => 500,
        ]);

        // 2. Switch to tenant context and seed initial data inside the tenant schema.
        $tenant->run(function () {
            // --- Roles ---
            $rolAdmin = Rol::create([
                'nombre'      => 'Administrador',
                'descripcion' => 'Acceso total al sistema',
                'permisos'    => ['*'],
            ]);

            Rol::create([
                'nombre'      => 'Recepción',
                'descripcion' => 'Gestión de socios y cobros',
                'permisos'    => ['socios.*', 'pagos.*', 'membresias.*'],
            ]);

            Rol::create([
                'nombre'      => 'Instructor',
                'descripcion' => 'Gestión de clases y asistencias',
                'permisos'    => ['clases.*', 'asistencias.*', 'turnos.*'],
            ]);

            // --- Sede principal ---
            $sede = Sede::create([
                'nombre'           => 'Sede Central',
                'direccion'        => 'Av. Corrientes 1234',
                'ciudad'           => 'Buenos Aires',
                'provincia'        => 'CABA',
                'telefono'         => '+54 11 1234-5678',
                'email'            => 'central@gymdemo.com',
                'horario_apertura' => '06:00',
                'horario_cierre'   => '23:00',
                'activa'           => true,
            ]);

            // --- Empleado admin ---
            $empleadoAdmin = Empleado::create([
                'sede_id'       => $sede->id,
                'rol_id'        => $rolAdmin->id,
                'nombre'        => 'Juan',
                'apellido'      => 'Administrador',
                'dni'           => '30000001',
                'email'         => 'admin@gymdemo.com',
                'fecha_ingreso' => now()->toDateString(),
                'activo'        => true,
            ]);

            // --- Métodos de pago ---
            MetodoPago::create(['nombre' => 'Efectivo', 'tipo' => 'efectivo', 'activo' => true]);
            MetodoPago::create(['nombre' => 'Transferencia', 'tipo' => 'digital', 'requiere_referencia' => true, 'activo' => true]);
            MetodoPago::create(['nombre' => 'MercadoPago', 'tipo' => 'digital', 'requiere_referencia' => true, 'activo' => true]);
            MetodoPago::create(['nombre' => 'Tarjeta de débito', 'tipo' => 'tarjeta', 'activo' => true]);
            MetodoPago::create(['nombre' => 'Tarjeta de crédito', 'tipo' => 'tarjeta', 'activo' => true]);

            // --- Tipos de clase ---
            TipoClase::create(['nombre' => 'Musculación', 'duracion_minutos' => 60, 'capacidad_maxima' => 30, 'activo' => true]);
            TipoClase::create(['nombre' => 'Spinning', 'duracion_minutos' => 45, 'capacidad_maxima' => 20, 'color' => '#FF5733', 'activo' => true]);
            TipoClase::create(['nombre' => 'Yoga', 'duracion_minutos' => 60, 'capacidad_maxima' => 15, 'color' => '#33FF57', 'activo' => true]);
            TipoClase::create(['nombre' => 'CrossFit', 'duracion_minutos' => 50, 'capacidad_maxima' => 12, 'color' => '#3357FF', 'activo' => true]);
            TipoClase::create(['nombre' => 'Funcional', 'duracion_minutos' => 45, 'capacidad_maxima' => 20, 'color' => '#FF33F5', 'activo' => true]);

            // --- Categorías de equipo ---
            CategoriaEquipo::create(['nombre' => 'Cardio', 'descripcion' => 'Cintas, bicicletas, elípticos']);
            CategoriaEquipo::create(['nombre' => 'Peso libre', 'descripcion' => 'Mancuernas, barras, discos']);
            CategoriaEquipo::create(['nombre' => 'Máquinas', 'descripcion' => 'Máquinas de musculación']);
            CategoriaEquipo::create(['nombre' => 'Accesorios', 'descripcion' => 'Colchonetas, bandas, pelotas']);

            // --- Planes ---
            $planMensual = Plan::create([
                'nombre'                  => 'Plan Mensual',
                'descripcion'             => 'Acceso ilimitado a musculación por 30 días',
                'tipo'                    => 'fijo',
                'duracion_dias'           => 30,
                'permite_congelamiento'   => true,
                'max_dias_congelamiento'  => 7,
                'max_veces_congelamiento' => 1,
                'activo'                  => true,
                'orden_display'           => 1,
                'color_ui'                => '#4F46E5',
            ]);

            $planTrimestral = Plan::create([
                'nombre'                   => 'Plan Trimestral',
                'descripcion'              => 'Acceso ilimitado por 90 días con descuento',
                'tipo'                     => 'fijo',
                'duracion_dias'            => 90,
                'permite_congelamiento'    => true,
                'max_dias_congelamiento'   => 15,
                'max_veces_congelamiento'  => 2,
                'permite_acceso_multisede' => true,
                'activo'                   => true,
                'orden_display'            => 2,
                'color_ui'                 => '#7C3AED',
            ]);

            $planPaseDia = Plan::create([
                'nombre'        => 'Pase Día',
                'descripcion'   => 'Acceso por un día completo',
                'tipo'          => 'pase_dia',
                'activo'        => true,
                'orden_display' => 3,
                'color_ui'      => '#10B981',
            ]);

            // --- Precios de planes ---
            PlanPrecio::create([
                'plan_id'          => $planMensual->id,
                'sede_id'          => $sede->id,
                'precio'           => 15000.00,
                'precio_matricula' => 5000.00,
                'moneda'           => 'ARS',
                'vigente_desde'    => now()->toDateString(),
                'empleado_id'      => $empleadoAdmin->id,
            ]);

            PlanPrecio::create([
                'plan_id'          => $planTrimestral->id,
                'sede_id'          => $sede->id,
                'precio'           => 38000.00,
                'precio_matricula' => 5000.00,
                'moneda'           => 'ARS',
                'vigente_desde'    => now()->toDateString(),
                'empleado_id'      => $empleadoAdmin->id,
            ]);

            PlanPrecio::create([
                'plan_id'       => $planPaseDia->id,
                'sede_id'       => $sede->id,
                'precio'        => 2000.00,
                'moneda'        => 'ARS',
                'vigente_desde' => now()->toDateString(),
                'empleado_id'   => $empleadoAdmin->id,
            ]);

            // --- Admin user ---
            // The users table lives in the public schema (central migration),
            // so we force the central connection while inside tenant context.
            $user = new User();
            $user->setConnection('central');
            $user->fill([
                'userable_type' => Empleado::class,
                'userable_id'   => $empleadoAdmin->id,
                'email'         => 'admin@gymdemo.com',
                'password'      => Hash::make('password'),
                'activo'        => true,
            ]);
            $user->saveQuietly();
        });

        $this->command->info("Tenant '{$tenant->slug}' creado con schema '{$tenant->schema_name}'.");
        $this->command->info('Login: admin@gymdemo.com / password');
        $this->command->info('Header: X-Tenant: demo');
    }
}
