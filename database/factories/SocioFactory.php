<?php

namespace Database\Factories;

use App\Models\Sede;
use Illuminate\Database\Eloquent\Factories\Factory;

class SocioFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'sede_id' => Sede::factory(),
            'nombre' => fake()->regexify('[A-Za-z0-9]{100}'),
            'apellido' => fake()->regexify('[A-Za-z0-9]{100}'),
            'dni' => fake()->regexify('[A-Za-z0-9]{20}'),
            'email' => fake()->safeEmail(),
            'telefono' => fake()->regexify('[A-Za-z0-9]{30}'),
            'fecha_nacimiento' => fake()->date(),
            'sexo' => fake()->randomElement(["masculino","femenino","otro"]),
            'direccion' => fake()->word(),
            'foto' => fake()->word(),
            'numero_socio' => fake()->regexify('[A-Za-z0-9]{30}'),
            'referido_por_id' => fake()->randomNumber(),
            'activo' => fake()->boolean(),
        ];
    }
}
