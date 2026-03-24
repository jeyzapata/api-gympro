<?php

namespace Database\Factories;

use App\Models\Membresia;
use App\Models\Socio;
use App\Models\TurnoClase;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservaFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'turno_clase_id' => TurnoClase::factory(),
            'socio_id' => Socio::factory(),
            'membresia_id' => Membresia::factory(),
            'estado' => fake()->randomElement(["reservada","confirmada","asistio","ausente","cancelada"]),
            'fecha_reserva' => fake()->dateTime(),
            'fecha_cancelacion' => fake()->dateTime(),
        ];
    }
}
