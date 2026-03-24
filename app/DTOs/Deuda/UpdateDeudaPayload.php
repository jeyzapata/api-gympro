<?php

declare(strict_types=1);

namespace App\DTOs\Deuda;

final readonly class UpdateDeudaPayload
{
    public function __construct(
        public ?int    $socioId = null,
        public ?int    $sedeId = null,
        public ?string $concepto = null,
        public ?string $monto = null,
        public ?string $fechaGeneracion = null,
        public ?int    $membresiaId = null,
        public ?string $fechaVencimiento = null,
        public ?int    $pagoId = null,
        public ?string $estado = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'socio_id'          => $this->socioId,
            'sede_id'           => $this->sedeId,
            'concepto'          => $this->concepto,
            'monto'             => $this->monto,
            'fecha_generacion'  => $this->fechaGeneracion,
            'membresia_id'      => $this->membresiaId,
            'fecha_vencimiento' => $this->fechaVencimiento,
            'pago_id'           => $this->pagoId,
            'estado'            => $this->estado,
        ], fn ($value) => $value !== null);
    }
}
