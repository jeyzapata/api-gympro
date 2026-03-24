<?php

namespace Database\Factories;

use App\Models\Empleado;
use App\Models\Socio;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedicionSocioFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'socio_id' => Socio::factory(),
            'empleado_id' => Empleado::factory(),
            'fecha' => fake()->date(),
            'peso_kg' => fake()->randomFloat(2, 0, 999.99),
            'altura_cm' => fake()->randomFloat(2, 0, 999.99),
            'imc' => fake()->randomFloat(2, 0, 99.99),
            'porcentaje_grasa' => fake()->randomFloat(2, 0, 999.99),
            'masa_muscular_kg' => fake()->randomFloat(2, 0, 999.99),
            'cintura_cm' => fake()->randomFloat(2, 0, 999.99),
            'cadera_cm' => fake()->randomFloat(2, 0, 999.99),
            'pecho_cm' => fake()->randomFloat(2, 0, 999.99),
            'notas' => fake()->text(),
        ];
    }
}
