<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\Sede;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmpleadoFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'sede_id' => Sede::factory(),
            'rol_id' => Role::factory(),
            'nombre' => fake()->regexify('[A-Za-z0-9]{100}'),
            'apellido' => fake()->regexify('[A-Za-z0-9]{100}'),
            'dni' => fake()->regexify('[A-Za-z0-9]{20}'),
            'email' => fake()->safeEmail(),
            'telefono' => fake()->regexify('[A-Za-z0-9]{30}'),
            'fecha_nacimiento' => fake()->date(),
            'fecha_ingreso' => fake()->date(),
            'especialidades' => '{}',
            'activo' => fake()->boolean(),
            'foto' => fake()->word(),
        ];
    }
}
