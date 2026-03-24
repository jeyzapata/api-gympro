<?php

namespace Database\Factories;

use App\Models\Pago;
use Illuminate\Database\Eloquent\Factories\Factory;

class PagoItemFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'pago_id' => Pago::factory(),
            'descripcion' => fake()->regexify('[A-Za-z0-9]{200}'),
            'cantidad' => fake()->randomNumber(),
            'precio_unitario' => fake()->randomFloat(2, 0, 99999999.99),
            'subtotal' => fake()->randomFloat(2, 0, 99999999.99),
        ];
    }
}
