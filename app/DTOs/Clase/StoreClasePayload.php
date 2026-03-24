<?php

declare(strict_types=1);

namespace App\DTOs\Clase;

final readonly class StoreClasePayload
{
    public function __construct(
        public int     $sedeId,
        public int     $tipoClaseId,
        public int     $empleadoId,
        public string  $nombre,
        public string  $horaInicio,
        public string  $horaFin,
        public int     $capacidadMaxima,
        public ?string $descripcion = null,
        public ?int    $diaSemana = null,
        public bool    $esRecurrente = true,
        public ?string $fechaInicioVigencia = null,
        public ?string $fechaFinVigencia = null,
        public bool    $activa = true,
    ) {}

    public function toArray(): array
    {
        return [
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
        ];
    }
}
