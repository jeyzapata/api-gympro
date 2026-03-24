<?php

namespace Database\Factories;

use App\Models\Empleado;
use App\Models\Plane;
use App\Models\Sede;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanPrecioFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'plan_id' => Plane::factory(),
            'sede_id' => Sede::factory(),
            'precio' => fake()->randomFloat(2, 0, 99999999.99),
            'precio_matricula' => fake()->randomFloat(2, 0, 99999999.99),
            'moneda' => fake()->regexify('[A-Za-z0-9]{3}'),
            'vigente_desde' => fake()->date(),
            'vigente_hasta' => fake()->date(),
            'motivo_cambio' => fake()->regexify('[A-Za-z0-9]{200}'),
            'empleado_id' => Empleado::factory(),
        ];
    }
}
