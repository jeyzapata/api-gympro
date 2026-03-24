<?php

declare(strict_types=1);

namespace App\DTOs\PlanPlataforma;

final readonly class UpdatePlanPlataformaPayload
{
    public function __construct(
        public ?string $nombre = null,
        public ?string $slug = null,
        public ?string $precioMensual = null,
        public ?string $descripcion = null,
        public ?string $moneda = null,
        public ?int    $maxSedes = null,
        public ?int    $maxEmpleados = null,
        public ?int    $maxSocios = null,
        public ?array  $features = null,
        public ?bool   $activo = null,
        public ?int    $ordenDisplay = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'nombre'        => $this->nombre,
            'slug'          => $this->slug,
            'precio_mensual' => $this->precioMensual,
            'descripcion'   => $this->descripcion,
            'moneda'        => $this->moneda,
            'max_sedes'     => $this->maxSedes,
            'max_empleados' => $this->maxEmpleados,
            'max_socios'    => $this->maxSocios,
            'features'      => $this->features,
            'activo'        => $this->activo,
            'orden_display' => $this->ordenDisplay,
        ], fn ($value) => $value !== null);
    }
}
