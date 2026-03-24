<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TenantFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'slug' => fake()->slug(),
            'nombre' => fake()->regexify('[A-Za-z0-9]{150}'),
            'email_admin' => fake()->regexify('[A-Za-z0-9]{150}'),
            'telefono' => fake()->regexify('[A-Za-z0-9]{30}'),
            'logo' => fake()->word(),
            'schema_name' => fake()->regexify('[A-Za-z0-9]{80}'),
            'plan_suscripcion' => fake()->randomElement(["trial","basico","pro","enterprise"]),
            'trial_ends_at' => fake()->dateTime(),
            'suscripcion_activa' => fake()->boolean(),
            'max_sedes' => fake()->randomDigitNotNull(),
            'max_empleados' => fake()->randomNumber(),
            'max_socios' => fake()->randomNumber(),
            'datos_fiscales' => '{}',
        ];
    }
}
