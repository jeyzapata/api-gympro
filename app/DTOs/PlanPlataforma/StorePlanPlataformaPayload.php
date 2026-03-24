<?php

declare(strict_types=1);

namespace App\DTOs\PlanPlataforma;

final readonly class StorePlanPlataformaPayload
{
    public function __construct(
        public string  $nombre,
        public string  $slug,
        public string  $precioMensual,
        public ?string $descripcion = null,
        public string  $moneda = 'ARS',
        public int     $maxSedes = 1,
        public int     $maxEmpleados = 10,
        public int     $maxSocios = 200,
        public ?array  $features = null,
        public bool    $activo = true,
        public int     $ordenDisplay = 0,
    ) {}

    public function toArray(): array
    {
        return [
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
        ];
    }
}
