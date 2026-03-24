<?php

namespace Database\Factories;

use App\Models\Empleado;
use App\Models\Socio;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanNutricionalFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'socio_id' => Socio::factory(),
            'empleado_id' => Empleado::factory(),
            'nombre' => fake()->regexify('[A-Za-z0-9]{150}'),
            'objetivo' => fake()->randomElement(["perdida_peso","ganancia_muscular","mantenimiento","rendimiento","otro"]),
            'descripcion' => fake()->text(),
            'fecha_inicio' => fake()->date(),
            'fecha_fin' => fake()->date(),
            'activo' => fake()->boolean(),
        ];
    }
}
