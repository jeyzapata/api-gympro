<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class PagoPlataformaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'factura_tenant_id' => $this->factura_tenant_id,
            'tenant_id'         => $this->tenant_id,
            'monto'             => $this->monto,
            'moneda'            => $this->moneda,
            'estado'            => $this->estado?->value,
            'mp_preference_id'  => $this->mp_preference_id,
            'mp_payment_id'     => $this->mp_payment_id,
            'mp_status'         => $this->mp_status,
            'mp_response'       => $this->mp_response,
            'fecha_pago'        => $this->fecha_pago?->toISOString(),
            'notas'             => $this->notas,
            'factura_tenant'    => new FacturaTenantResource($this->whenLoaded('facturaTenant')),
            'tenant'            => new TenantResource($this->whenLoaded('tenant')),
            'created_at'        => $this->created_at?->toISOString(),
            'updated_at'        => $this->updated_at?->toISOString(),
        ];
    }
}
