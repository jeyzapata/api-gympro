<?php

namespace Database\Factories;

use App\Models\Empleado;
use Illuminate\Database\Eloquent\Factories\Factory;

class HorarioEmpleadoFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'empleado_id' => Empleado::factory(),
            'dia_semana' => fake()->numberBetween(-8, 8),
            'hora_entrada' => fake()->time(),
            'hora_salida' => fake()->time(),
        ];
    }
}
