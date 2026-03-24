<?php

declare(strict_types=1);

namespace App\DTOs\Reserva;

final readonly class UpdateReservaPayload
{
    public function __construct(
        public ?int    $turnoClaseId = null,
        public ?int    $socioId = null,
        public ?int    $membresiaId = null,
        public ?string $estado = null,
        public ?string $fechaReserva = null,
        public ?string $fechaCancelacion = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'turno_clase_id'    => $this->turnoClaseId,
            'socio_id'          => $this->socioId,
            'membresia_id'      => $this->membresiaId,
            'estado'            => $this->estado,
            'fecha_reserva'     => $this->fechaReserva,
            'fecha_cancelacion' => $this->fechaCancelacion,
        ], fn ($value) => $value !== null);
    }
}
