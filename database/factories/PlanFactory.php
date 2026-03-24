<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PlanFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->regexify('[A-Za-z0-9]{100}'),
            'descripcion' => fake()->text(),
            'tipo' => fake()->randomElement(["fijo","pase_dia","clases_sueltas"]),
            'duracion_dias' => fake()->randomNumber(),
            'cantidad_clases' => fake()->randomNumber(),
            'permite_congelamiento' => fake()->boolean(),
            'max_dias_congelamiento' => fake()->randomNumber(),
            'max_veces_congelamiento' => fake()->randomDigitNotNull(),
            'permite_acceso_multisede' => fake()->boolean(),
            'activo' => fake()->boolean(),
            'orden_display' => fake()->randomDigitNotNull(),
            'color_ui' => fake()->regexify('[A-Za-z0-9]{7}'),
        ];
    }
}
