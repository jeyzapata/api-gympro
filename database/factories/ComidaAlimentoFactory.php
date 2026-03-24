<?php

namespace Database\Factories;

use App\Models\Alimento;
use App\Models\ComidaDiaria;
use Illuminate\Database\Eloquent\Factories\Factory;

class ComidaAlimentoFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'comida_diaria_id' => ComidaDiaria::factory(),
            'alimento_id' => Alimento::factory(),
            'cantidad_gramos' => fake()->randomFloat(2, 0, 99999.99),
        ];
    }
}
