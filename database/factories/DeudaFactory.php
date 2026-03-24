<?php

namespace Database\Factories;

use App\Models\Membresia;
use App\Models\Pago;
use App\Models\Sede;
use App\Models\Socio;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeudaFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'socio_id' => Socio::factory(),
            'membresia_id' => Membresia::factory(),
            'sede_id' => Sede::factory(),
            'concepto' => fake()->regexify('[A-Za-z0-9]{200}'),
            'monto' => fake()->randomFloat(2, 0, 99999999.99),
            'fecha_generacion' => fake()->date(),
            'fecha_vencimiento' => fake()->date(),
            'estado' => fake()->randomElement(["pendiente","pagada","anulada"]),
            'pago_id' => Pago::factory(),
        ];
    }
}
