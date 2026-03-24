<?php

declare(strict_types=1);

namespace App\DTOs\MovimientoCaja;

final readonly class StoreMovimientoCajaPayload
{
    public function __construct(
        public int     $cajaId,
        public string  $tipo,
        public string  $monto,
        public string  $concepto,
        public int     $empleadoId,
        public ?int    $pagoId = null,
    ) {}

    public function toArray(): array
    {
        return [
            'caja_id'     => $this->cajaId,
            'pago_id'     => $this->pagoId,
            'tipo'        => $this->tipo,
            'monto'       => $this->monto,
            'concepto'    => $this->concepto,
            'empleado_id' => $this->empleadoId,
        ];
    }
}
