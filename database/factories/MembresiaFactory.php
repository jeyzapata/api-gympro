<?php

namespace Database\Factories;

use App\Models\PlanPrecio;
use App\Models\Plane;
use App\Models\Sede;
use App\Models\Socio;
use Illuminate\Database\Eloquent\Factories\Factory;

class MembresiaFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'socio_id' => Socio::factory(),
            'plan_id' => Plane::factory(),
            'plan_precio_id' => PlanPrecio::factory(),
            'sede_id' => Sede::factory(),
            'fecha_inicio' => fake()->date(),
            'fecha_fin' => fake()->date(),
            'clases_restantes' => fake()->randomNumber(),
            'estado' => fake()->randomElement(["activa","vencida","congelada","cancelada","pendiente_pago"]),
            'fecha_congelamiento' => fake()->date(),
            'fecha_descongelamiento' => fake()->date(),
            'dias_congelados_usados' => fake()->randomNumber(),
            'veces_congelado' => fake()->randomDigitNotNull(),
            'auto_renovar' => fake()->boolean(),
            'notas' => fake()->text(),
        ];
    }
}
