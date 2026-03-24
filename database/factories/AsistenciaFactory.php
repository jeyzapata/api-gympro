<?php

namespace Database\Factories;

use App\Models\Membresia;
use App\Models\Sede;
use App\Models\Socio;
use App\Models\TurnoClase;
use Illuminate\Database\Eloquent\Factories\Factory;

class AsistenciaFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'socio_id' => Socio::factory(),
            'sede_id' => Sede::factory(),
            'turno_clase_id' => TurnoClase::factory(),
            'membresia_id' => Membresia::factory(),
            'fecha_hora_ingreso' => fake()->dateTime(),
            'fecha_hora_egreso' => fake()->dateTime(),
            'tipo' => fake()->randomElement(["clase","acceso_libre"]),
        ];
    }
}
