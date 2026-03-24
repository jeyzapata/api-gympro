<?php

declare(strict_types=1);

namespace App\DTOs\PlanPrecio;

final readonly class UpdatePlanPrecioPayload
{
    public function __construct(
        public ?int    $planId = null,
        public ?int    $sedeId = null,
        public ?string $precio = null,
        public ?string $precioMatricula = null,
        public ?string $moneda = null,
        public ?string $vigenteDesde = null,
        public ?string $vigenteHasta = null,
        public ?string $motivoCambio = null,
        public ?int    $empleadoId = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'plan_id'          => $this->planId,
            'sede_id'          => $this->sedeId,
            'precio'           => $this->precio,
            'precio_matricula' => $this->precioMatricula,
            'moneda'           => $this->moneda,
            'vigente_desde'    => $this->vigenteDesde,
            'vigente_hasta'    => $this->vigenteHasta,
            'motivo_cambio'    => $this->motivoCambio,
            'empleado_id'      => $this->empleadoId,
        ], fn ($value) => $value !== null);
    }
}
