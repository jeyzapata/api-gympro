<?php

declare(strict_types=1);

namespace App\DTOs\PlanPrecio;

final readonly class StorePlanPrecioPayload
{
    public function __construct(
        public int     $planId,
        public string  $precio,
        public string  $vigentDesde,
        public int     $empleadoId,
        public ?int    $sedeId = null,
        public string  $precioMatricula = '0',
        public string  $moneda = 'ARS',
        public ?string $vigenteHasta = null,
        public ?string $motivoCambio = null,
    ) {}

    public function toArray(): array
    {
        return [
            'plan_id'          => $this->planId,
            'sede_id'          => $this->sedeId,
            'precio'           => $this->precio,
            'precio_matricula' => $this->precioMatricula,
            'moneda'           => $this->moneda,
            'vigente_desde'    => $this->vigentDesde,
            'vigente_hasta'    => $this->vigenteHasta,
            'motivo_cambio'    => $this->motivoCambio,
            'empleado_id'      => $this->empleadoId,
        ];
    }
}
