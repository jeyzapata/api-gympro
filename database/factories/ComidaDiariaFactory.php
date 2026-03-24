<?php

namespace Database\Factories;

use App\Models\PlanNutricionale;
use Illuminate\Database\Eloquent\Factories\Factory;

class ComidaDiariaFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'plan_nutricional_id' => PlanNutricionale::factory(),
            'dia_semana' => fake()->numberBetween(-8, 8),
            'tipo_comida' => fake()->randomElement(["desayuno","almuerzo","merienda","cena","colacion"]),
            'hora_sugerida' => fake()->time(),
            'notas' => fake()->text(),
        ];
    }
}
