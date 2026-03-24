<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class PlanPrecioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'plan_id' => $this->plan_id,
            'sede_id' => $this->sede_id,
            'precio' => $this->precio,
            'precio_matricula' => $this->precio_matricula,
            'moneda' => $this->moneda,
            'vigente_desde' => $this->vigente_desde,
            'vigente_hasta' => $this->vigente_hasta,
            'motivo_cambio' => $this->motivo_cambio,
            'empleado_id' => $this->empleado_id,
        ];
    }
}
