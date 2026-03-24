<?php

declare(strict_types=1);

namespace App\DTOs\TurnoClase;

final readonly class UpdateTurnoClasePayload
{
    public function __construct(
        public ?int    $claseId = null,
        public ?string $fecha = null,
        public ?string $horaInicio = null,
        public ?string $horaFin = null,
        public ?int    $instructorId = null,
        public ?string $estado = null,
        public ?int    $capacidadMaxima = null,
        public ?string $notas = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'clase_id'         => $this->claseId,
            'fecha'            => $this->fecha,
            'hora_inicio'      => $this->horaInicio,
            'hora_fin'         => $this->horaFin,
            'instructor_id'    => $this->instructorId,
            'estado'           => $this->estado,
            'capacidad_maxima' => $this->capacidadMaxima,
            'notas'            => $this->notas,
        ], fn ($value) => $value !== null);
    }
}
