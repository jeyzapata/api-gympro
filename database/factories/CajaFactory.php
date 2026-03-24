<?php

namespace Database\Factories;

use App\Models\Empleado;
use App\Models\Sede;
use Illuminate\Database\Eloquent\Factories\Factory;

class CajaFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'sede_id' => Sede::factory(),
            'empleado_id' => Empleado::factory(),
            'fecha_apertura' => fake()->dateTime(),
            'monto_apertura' => fake()->randomFloat(2, 0, 99999999.99),
            'fecha_cierre' => fake()->dateTime(),
            'monto_cierre_real' => fake()->randomFloat(2, 0, 99999999.99),
            'monto_cierre_sistema' => fake()->randomFloat(2, 0, 99999999.99),
            'diferencia' => fake()->randomFloat(2, 0, 99999999.99),
            'estado' => fake()->randomElement(["abierta","cerrada"]),
            'observaciones' => fake()->text(),
        ];
    }
}
