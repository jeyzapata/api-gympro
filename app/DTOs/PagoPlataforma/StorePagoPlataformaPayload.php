<?php

declare(strict_types=1);

namespace App\DTOs\PagoPlataforma;

final readonly class StorePagoPlataformaPayload
{
    public function __construct(
        public int     $facturaTenantId,
        public int     $tenantId,
        public string  $monto,
        public string  $moneda = 'ARS',
        public string  $estado = 'pendiente',
        public ?string $mpPreferenceId = null,
        public ?string $mpPaymentId = null,
        public ?string $mpStatus = null,
        public ?array  $mpResponse = null,
        public ?string $fechaPago = null,
        public ?string $notas = null,
    ) {}

    public function toArray(): array
    {
        return [
            'factura_tenant_id' => $this->facturaTenantId,
            'tenant_id'         => $this->tenantId,
            'monto'             => $this->monto,
            'moneda'            => $this->moneda,
            'estado'            => $this->estado,
            'mp_preference_id'  => $this->mpPreferenceId,
            'mp_payment_id'     => $this->mpPaymentId,
            'mp_status'         => $this->mpStatus,
            'mp_response'       => $this->mpResponse,
            'fecha_pago'        => $this->fechaPago,
            'notas'             => $this->notas,
        ];
    }
}
