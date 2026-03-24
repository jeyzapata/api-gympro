<?php

namespace Database\Factories;

use App\Models\Clase;
use App\Models\Empleado;
use Illuminate\Database\Eloquent\Factories\Factory;

class TurnoClaseFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'clase_id' => Clase::factory(),
            'fecha' => fake()->date(),
            'hora_inicio' => fake()->time(),
            'hora_fin' => fake()->time(),
            'instructor_id' => Empleado::factory(),
            'estado' => fake()->randomElement(["programado","en_curso","finalizado","cancelado"]),
            'capacidad_maxima' => fake()->randomNumber(),
            'notas' => fake()->text(),
        ];
    }
}
