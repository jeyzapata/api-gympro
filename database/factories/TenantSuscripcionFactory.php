<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class TenantSuscripcionFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'plan_anterior' => fake()->regexify('[A-Za-z0-9]{30}'),
            'plan_nuevo' => fake()->regexify('[A-Za-z0-9]{30}'),
            'motivo' => fake()->regexify('[A-Za-z0-9]{200}'),
            'precio_mensual' => fake()->randomFloat(2, 0, 99999999.99),
            'activa_desde' => fake()->date(),
            'activa_hasta' => fake()->date(),
        ];
    }
}
