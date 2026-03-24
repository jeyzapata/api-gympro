<?php

namespace Database\Factories;

use App\Models\Empleado;
use App\Models\Equipo;
use Illuminate\Database\Eloquent\Factories\Factory;

class MantenimientoFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'equipo_id' => Equipo::factory(),
            'empleado_id' => Empleado::factory(),
            'tipo' => fake()->randomElement(["preventivo","correctivo","revision"]),
            'descripcion' => fake()->text(),
            'fecha_programada' => fake()->date(),
            'fecha_realizado' => fake()->date(),
            'costo' => fake()->randomFloat(2, 0, 99999999.99),
            'proveedor' => fake()->regexify('[A-Za-z0-9]{150}'),
            'estado' => fake()->randomElement(["programado","en_progreso","completado","cancelado"]),
            'proxima_revision' => fake()->date(),
        ];
    }
}
