<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class FacturaTenantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                 => $this->id,
            'tenant_id'          => $this->tenant_id,
            'plan_plataforma_id' => $this->plan_plataforma_id,
            'numero_factura'     => $this->numero_factura,
            'monto'              => $this->monto,
            'moneda'             => $this->moneda,
            'periodo_inicio'     => $this->periodo_inicio?->format('Y-m-d'),
            'periodo_fin'        => $this->periodo_fin?->format('Y-m-d'),
            'fecha_vencimiento'  => $this->fecha_vencimiento?->format('Y-m-d'),
            'estado'             => $this->estado?->value,
            'fecha_pago'         => $this->fecha_pago?->format('Y-m-d'),
            'notas'              => $this->notas,
            'tenant'             => new TenantResource($this->whenLoaded('tenant')),
            'plan_plataforma'    => new PlanPlataformaResource($this->whenLoaded('planPlataforma')),
            'created_at'         => $this->created_at?->toISOString(),
            'updated_at'         => $this->updated_at?->toISOString(),
        ];
    }
}
