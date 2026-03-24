<?php

declare(strict_types=1);

namespace App\DTOs\Clase;

final readonly class UpdateClasePayload
{
    public function __construct(
        public ?int    $sedeId = null,
        public ?int    $tipoClaseId = null,
        public ?int    $empleadoId = null,
        public ?string $nombre = null,
        public ?string $descripcion = null,
        public ?int    $diaSemana = null,
        public ?string $horaInicio = null,
        public ?string $horaFin = null,
        public ?int    $capacidadMaxima = null,
        public ?bool   $esRecurrente = null,
        public ?string $fechaInicioVigencia = null,
        public ?string $fechaFinVigencia = null,
        public ?bool   $activa = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'sede_id'               => $this->sedeId,
            'tipo_clase_id'         => $this->tipoClaseId,
            'empleado_id'           => $this->empleadoId,
            'nombre'                => $this->nombre,
            'descripcion'           => $this->descripcion,
            'dia_semana'            => $this->diaSemana,
            'hora_inicio'           => $this->horaInicio,
            'hora_fin'              => $this->horaFin,
            'capacidad_maxima'      => $this->capacidadMaxima,
            'es_recurrente'         => $this->esRecurrente,
            'fecha_inicio_vigencia' => $this->fechaInicioVigencia,
            'fecha_fin_vigencia'    => $this->fechaFinVigencia,
            'activa'                => $this->activa,
        ], fn ($value) => $value !== null);
    }
}
