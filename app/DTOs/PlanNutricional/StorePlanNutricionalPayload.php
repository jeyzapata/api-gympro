<?php

declare(strict_types=1);

namespace App\DTOs\PlanNutricional;

final readonly class StorePlanNutricionalPayload
{
    public function __construct(
        public int     $socioId,
        public int     $empleadoId,
        public string  $nombre,
        public string  $objetivo,
        public string  $fechaInicio,
        public ?string $descripcion = null,
        public ?string $fechaFin = null,
        public bool    $activo = true,
    ) {}

    public function toArray(): array
    {
        return [
            'socio_id'     => $this->socioId,
            'empleado_id'  => $this->empleadoId,
            'nombre'       => $this->nombre,
            'objetivo'     => $this->objetivo,
            'descripcion'  => $this->descripcion,
            'fecha_inicio' => $this->fechaInicio,
            'fecha_fin'    => $this->fechaFin,
            'activo'       => $this->activo,
        ];
    }
}
