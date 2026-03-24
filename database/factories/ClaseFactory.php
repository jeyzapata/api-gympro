<?php

namespace Database\Factories;

use App\Models\Empleado;
use App\Models\Sede;
use App\Models\TipoClase;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClaseFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'sede_id' => Sede::factory(),
            'tipo_clase_id' => TipoClase::factory(),
            'empleado_id' => Empleado::factory(),
            'nombre' => fake()->regexify('[A-Za-z0-9]{150}'),
            'descripcion' => fake()->text(),
            'dia_semana' => fake()->numberBetween(-8, 8),
            'hora_inicio' => fake()->time(),
            'hora_fin' => fake()->time(),
            'capacidad_maxima' => fake()->randomNumber(),
            'es_recurrente' => fake()->boolean(),
            'fecha_inicio_vigencia' => fake()->date(),
            'fecha_fin_vigencia' => fake()->date(),
            'activa' => fake()->boolean(),
        ];
    }
}
