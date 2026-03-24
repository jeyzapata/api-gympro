<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class PlanPlataformaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'nombre'         => $this->nombre,
            'descripcion'    => $this->descripcion,
            'slug'           => $this->slug,
            'precio_mensual' => $this->precio_mensual,
            'moneda'         => $this->moneda,
            'max_sedes'      => $this->max_sedes,
            'max_empleados'  => $this->max_empleados,
            'max_socios'     => $this->max_socios,
            'features'       => $this->features,
            'activo'         => $this->activo,
            'orden_display'  => $this->orden_display,
            'created_at'     => $this->created_at?->toISOString(),
            'updated_at'     => $this->updated_at?->toISOString(),
        ];
    }
}
