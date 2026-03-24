<?php

namespace Database\Factories;

use App\Models\Plane;
use App\Models\Sede;
use Illuminate\Database\Eloquent\Factories\Factory;

class PromocionFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'codigo' => fake()->regexify('[A-Za-z0-9]{50}'),
            'nombre' => fake()->regexify('[A-Za-z0-9]{150}'),
            'descripcion' => fake()->text(),
            'tipo_descuento' => fake()->randomElement(["porcentaje","monto_fijo","meses_gratis"]),
            'valor' => fake()->randomFloat(2, 0, 99999999.99),
            'aplica_a' => fake()->randomElement(["todos","plan_especifico","primera_membresia"]),
            'plan_id' => Plane::factory(),
            'sede_id' => Sede::factory(),
            'usos_maximos' => fake()->randomNumber(),
            'usos_actuales' => fake()->randomNumber(),
            'un_uso_por_socio' => fake()->boolean(),
            'vigente_desde' => fake()->dateTime(),
            'vigente_hasta' => fake()->dateTime(),
            'activa' => fake()->boolean(),
        ];
    }
}
