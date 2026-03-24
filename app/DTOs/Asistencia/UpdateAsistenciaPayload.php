<?php

declare(strict_types=1);

namespace App\DTOs\Asistencia;

final readonly class UpdateAsistenciaPayload
{
    public function __construct(
        public ?int    $socioId = null,
        public ?int    $sedeId = null,
        public ?int    $turnoClaseId = null,
        public ?int    $membresiaId = null,
        public ?string $fechaHoraIngreso = null,
        public ?string $fechaHoraEgreso = null,
        public ?string $tipo = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'socio_id'            => $this->socioId,
            'sede_id'             => $this->sedeId,
            'turno_clase_id'      => $this->turnoClaseId,
            'membresia_id'        => $this->membresiaId,
            'fecha_hora_ingreso'  => $this->fechaHoraIngreso,
            'fecha_hora_egreso'   => $this->fechaHoraEgreso,
            'tipo'                => $this->tipo,
        ], fn ($value) => $value !== null);
    }
}
