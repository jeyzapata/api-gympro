<?php

declare(strict_types=1);

namespace App\DTOs\MovimientoCaja;

final readonly class UpdateMovimientoCajaPayload
{
    public function __construct(
        public ?int    $cajaId = null,
        public ?int    $pagoId = null,
        public ?string $tipo = null,
        public ?string $monto = null,
        public ?string $concepto = null,
        public ?int    $empleadoId = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'caja_id'     => $this->cajaId,
            'pago_id'     => $this->pagoId,
            'tipo'        => $this->tipo,
            'monto'       => $this->monto,
            'concepto'    => $this->concepto,
            'empleado_id' => $this->empleadoId,
        ], fn ($value) => $value !== null);
    }
}
