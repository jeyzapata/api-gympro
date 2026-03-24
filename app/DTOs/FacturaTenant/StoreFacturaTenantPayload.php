<?php

declare(strict_types=1);

namespace App\DTOs\FacturaTenant;

final readonly class StoreFacturaTenantPayload
{
    public function __construct(
        public int     $tenantId,
        public int     $planPlataformaId,
        public string  $numeroFactura,
        public string  $monto,
        public string  $periodoInicio,
        public string  $periodoFin,
        public string  $fechaVencimiento,
        public string  $moneda = 'ARS',
        public string  $estado = 'pendiente',
        public ?string $fechaPago = null,
        public ?string $notas = null,
    ) {}

    public function toArray(): array
    {
        return [
            'tenant_id'          => $this->tenantId,
            'plan_plataforma_id' => $this->planPlataformaId,
            'numero_factura'     => $this->numeroFactura,
            'monto'              => $this->monto,
            'moneda'             => $this->moneda,
            'periodo_inicio'     => $this->periodoInicio,
            'periodo_fin'        => $this->periodoFin,
            'fecha_vencimiento'  => $this->fechaVencimiento,
            'estado'             => $this->estado,
            'fecha_pago'         => $this->fechaPago,
            'notas'              => $this->notas,
        ];
    }
}
