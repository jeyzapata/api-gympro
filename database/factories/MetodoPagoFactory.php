<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MetodoPagoFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->regexify('[A-Za-z0-9]{60}'),
            'tipo' => fake()->randomElement(["efectivo","digital","tarjeta","otro"]),
            'requiere_referencia' => fake()->boolean(),
            'activo' => fake()->boolean(),
        ];
    }
}
