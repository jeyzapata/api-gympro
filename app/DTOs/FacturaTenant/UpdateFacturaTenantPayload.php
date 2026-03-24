<?php

declare(strict_types=1);

namespace App\DTOs\FacturaTenant;

final readonly class UpdateFacturaTenantPayload
{
    public function __construct(
        public ?int    $tenantId = null,
        public ?int    $planPlataformaId = null,
        public ?string $numeroFactura = null,
        public ?string $monto = null,
        public ?string $moneda = null,
        public ?string $periodoInicio = null,
        public ?string $periodoFin = null,
        public ?string $fechaVencimiento = null,
        public ?string $estado = null,
        public ?string $fechaPago = null,
        public ?string $notas = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
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
        ], fn ($value) => $value !== null);
    }
}
