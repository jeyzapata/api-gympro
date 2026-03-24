<?php

declare(strict_types=1);

namespace App\DTOs\Asistencia;

final readonly class StoreAsistenciaPayload
{
    public function __construct(
        public int     $socioId,
        public int     $sedeId,
        public string  $fechaHoraIngreso,
        public string  $tipo,
        public ?int    $turnoClaseId = null,
        public ?int    $membresiaId = null,
        public ?string $fechaHoraEgreso = null,
    ) {}

    public function toArray(): array
    {
        return [
            'socio_id'            => $this->socioId,
            'sede_id'             => $this->sedeId,
            'turno_clase_id'      => $this->turnoClaseId,
            'membresia_id'        => $this->membresiaId,
            'fecha_hora_ingreso'  => $this->fechaHoraIngreso,
            'fecha_hora_egreso'   => $this->fechaHoraEgreso,
            'tipo'                => $this->tipo,
        ];
    }
}
