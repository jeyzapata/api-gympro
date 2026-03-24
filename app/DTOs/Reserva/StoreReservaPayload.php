<?php

declare(strict_types=1);

namespace App\DTOs\Reserva;

final readonly class StoreReservaPayload
{
    public function __construct(
        public int     $turnoClaseId,
        public int     $socioId,
        public string  $fechaReserva,
        public ?int    $membresiaId = null,
        public ?string $fechaCancelacion = null,
        public string  $estado = 'reservada',
    ) {}

    public function toArray(): array
    {
        return [
            'turno_clase_id'    => $this->turnoClaseId,
            'socio_id'          => $this->socioId,
            'fecha_reserva'     => $this->fechaReserva,
            'membresia_id'      => $this->membresiaId,
            'fecha_cancelacion' => $this->fechaCancelacion,
            'estado'            => $this->estado,
        ];
    }
}
