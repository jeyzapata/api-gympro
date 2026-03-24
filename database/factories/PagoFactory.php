<?php

namespace Database\Factories;

use App\Models\Empleado;
use App\Models\Membresia;
use App\Models\MetodoPago;
use App\Models\Promocione;
use App\Models\Sede;
use App\Models\Socio;
use Illuminate\Database\Eloquent\Factories\Factory;

class PagoFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'membresia_id' => Membresia::factory(),
            'socio_id' => Socio::factory(),
            'sede_id' => Sede::factory(),
            'empleado_id' => Empleado::factory(),
            'metodo_pago_id' => MetodoPago::factory(),
            'promocion_id' => Promocione::factory(),
            'monto_bruto' => fake()->randomFloat(2, 0, 99999999.99),
            'monto_descuento' => fake()->randomFloat(2, 0, 99999999.99),
            'monto_matricula' => fake()->randomFloat(2, 0, 99999999.99),
            'monto_final' => fake()->randomFloat(2, 0, 99999999.99),
            'moneda' => fake()->regexify('[A-Za-z0-9]{3}'),
            'es_pago_parcial' => fake()->boolean(),
            'cuota_numero' => fake()->randomDigitNotNull(),
            'cuota_total' => fake()->randomDigitNotNull(),
            'concepto' => fake()->regexify('[A-Za-z0-9]{200}'),
            'numero_comprobante' => fake()->regexify('[A-Za-z0-9]{80}'),
            'referencia_externa' => fake()->regexify('[A-Za-z0-9]{150}'),
            'estado' => fake()->randomElement(["pendiente","pagado","anulado","reembolsado"]),
            'fecha_pago' => fake()->dateTime(),
            'fecha_vencimiento' => fake()->date(),
            'anulado_por_id' => fake()->randomNumber(),
            'motivo_anulacion' => fake()->regexify('[A-Za-z0-9]{200}'),
            'notas' => fake()->text(),
        ];
    }
}
