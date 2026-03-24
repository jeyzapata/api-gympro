<?php

namespace Database\Factories;

use App\Models\Caja;
use App\Models\Empleado;
use App\Models\Pago;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovimientoCajaFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'caja_id' => Caja::factory(),
            'pago_id' => Pago::factory(),
            'tipo' => fake()->randomElement(["ingreso","egreso","ajuste"]),
            'monto' => fake()->randomFloat(2, 0, 99999999.99),
            'concepto' => fake()->regexify('[A-Za-z0-9]{200}'),
            'empleado_id' => Empleado::factory(),
        ];
    }
}
