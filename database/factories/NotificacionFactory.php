<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificacionFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'titulo' => fake()->regexify('[A-Za-z0-9]{150}'),
            'cuerpo' => fake()->text(),
            'tipo' => fake()->randomElement(["membresia","pago","clase","mantenimiento","promocion","general"]),
            'leida' => fake()->boolean(),
            'leida_at' => fake()->dateTime(),
            'data' => '{}',
        ];
    }
}
