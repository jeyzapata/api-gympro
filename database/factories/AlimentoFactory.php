<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AlimentoFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->regexify('[A-Za-z0-9]{150}'),
            'calorias_por_100g' => fake()->randomFloat(2, 0, 99999.99),
            'proteinas_por_100g' => fake()->randomFloat(2, 0, 99999.99),
            'carbohidratos_por_100g' => fake()->randomFloat(2, 0, 99999.99),
            'grasas_por_100g' => fake()->randomFloat(2, 0, 99999.99),
            'fibra_por_100g' => fake()->randomFloat(2, 0, 99999.99),
        ];
    }
}
