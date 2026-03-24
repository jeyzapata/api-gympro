<?php

namespace Database\Factories;

use App\Models\Plane;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanBeneficioFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'plan_id' => Plane::factory(),
            'descripcion' => fake()->regexify('[A-Za-z0-9]{200}'),
            'incluido' => fake()->boolean(),
            'orden' => fake()->randomDigitNotNull(),
        ];
    }
}
