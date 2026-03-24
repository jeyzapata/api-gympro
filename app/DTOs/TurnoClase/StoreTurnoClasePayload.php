<?php

declare(strict_types=1);

namespace App\DTOs\TurnoClase;

final readonly class StoreTurnoClasePayload
{
    public function __construct(
        public int     $claseId,
        public string  $fecha,
        public string  $horaInicio,
        public string  $horaFin,
        public ?int    $instructorId = null,
        public string  $estado = 'programado',
        public ?int    $capacidadMaxima = null,
        public ?string $notas = null,
    ) {}

    public function toArray(): array
    {
        return [
            'clase_id'         => $this->claseId,
            'fecha'            => $this->fecha,
            'hora_inicio'      => $this->horaInicio,
            'hora_fin'         => $this->horaFin,
            'instructor_id'    => $this->instructorId,
            'estado'           => $this->estado,
            'capacidad_maxima' => $this->capacidadMaxima,
            'notas'            => $this->notas,
        ];
    }
}
