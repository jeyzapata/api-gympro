<?php

declare(strict_types=1);

namespace App\DTOs\PlanNutricional;

final readonly class UpdatePlanNutricionalPayload
{
    public function __construct(
        public ?int    $socioId = null,
        public ?int    $empleadoId = null,
        public ?string $nombre = null,
        public ?string $objetivo = null,
        public ?string $descripcion = null,
        public ?string $fechaInicio = null,
        public ?string $fechaFin = null,
        public ?bool   $activo = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'socio_id'     => $this->socioId,
            'empleado_id'  => $this->empleadoId,
            'nombre'       => $this->nombre,
            'objetivo'     => $this->objetivo,
            'descripcion'  => $this->descripcion,
            'fecha_inicio' => $this->fechaInicio,
            'fecha_fin'    => $this->fechaFin,
            'activo'       => $this->activo,
        ], fn ($value) => $value !== null);
    }
}
