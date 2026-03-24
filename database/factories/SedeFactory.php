<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SedeFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->regexify('[A-Za-z0-9]{120}'),
            'direccion' => fake()->word(),
            'ciudad' => fake()->regexify('[A-Za-z0-9]{80}'),
            'provincia' => fake()->regexify('[A-Za-z0-9]{80}'),
            'telefono' => fake()->regexify('[A-Za-z0-9]{30}'),
            'email' => fake()->safeEmail(),
            'horario_apertura' => fake()->time(),
            'horario_cierre' => fake()->time(),
            'activa' => fake()->boolean(),
        ];
    }
}
