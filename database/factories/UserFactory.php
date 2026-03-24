<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'userable_type' => fake()->word(),
            'userable_id' => fake()->randomNumber(),
            'email' => fake()->safeEmail(),
            'password' => fake()->password(),
            'email_verified_at' => fake()->dateTime(),
            'push_token' => fake()->word(),
            'ultimo_login' => fake()->dateTime(),
            'activo' => fake()->boolean(),
            'rememberToken' => fake()->word(),
        ];
    }
}
