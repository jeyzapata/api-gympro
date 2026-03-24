<?php

declare(strict_types=1);

namespace App\DTOs\Deuda;

final readonly class StoreDeudaPayload
{
    public function __construct(
        public int     $socioId,
        public int     $sedeId,
        public string  $concepto,
        public string  $monto,
        public string  $fechaGeneracion,
        public ?int    $membresiaId = null,
        public ?string $fechaVencimiento = null,
        public ?int    $pagoId = null,
        public string  $estado = 'pendiente',
    ) {}

    public function toArray(): array
    {
        return [
            'socio_id'          => $this->socioId,
            'sede_id'           => $this->sedeId,
            'concepto'          => $this->concepto,
            'monto'             => $this->monto,
            'fecha_generacion'  => $this->fechaGeneracion,
            'membresia_id'      => $this->membresiaId,
            'fecha_vencimiento' => $this->fechaVencimiento,
            'pago_id'           => $this->pagoId,
            'estado'            => $this->estado,
        ];
    }
}
