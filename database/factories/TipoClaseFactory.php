<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TipoClaseFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->regexify('[A-Za-z0-9]{100}'),
            'descripcion' => fake()->text(),
            'duracion_minutos' => fake()->randomNumber(),
            'capacidad_maxima' => fake()->randomNumber(),
            'color' => fake()->regexify('[A-Za-z0-9]{7}'),
            'activo' => fake()->boolean(),
        ];
    }
}
