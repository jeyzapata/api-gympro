<?php

namespace Database\Factories;

use App\Models\CategoriaEquipo;
use App\Models\Sede;
use Illuminate\Database\Eloquent\Factories\Factory;

class EquipoFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'sede_id' => Sede::factory(),
            'categoria_equipo_id' => CategoriaEquipo::factory(),
            'nombre' => fake()->regexify('[A-Za-z0-9]{150}'),
            'marca' => fake()->regexify('[A-Za-z0-9]{80}'),
            'modelo' => fake()->regexify('[A-Za-z0-9]{80}'),
            'numero_serie' => fake()->regexify('[A-Za-z0-9]{100}'),
            'fecha_adquisicion' => fake()->date(),
            'valor_adquisicion' => fake()->randomFloat(2, 0, 99999999.99),
            'estado' => fake()->randomElement(["operativo","en_mantenimiento","fuera_de_servicio","dado_de_baja"]),
            'ubicacion' => fake()->regexify('[A-Za-z0-9]{100}'),
            'foto' => fake()->word(),
            'notas' => fake()->text(),
        ];
    }
}
