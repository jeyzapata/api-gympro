<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class CajaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sede_id' => $this->sede_id,
            'empleado_id' => $this->empleado_id,
            'fecha_apertura' => $this->fecha_apertura,
            'monto_apertura' => $this->monto_apertura,
            'fecha_cierre' => $this->fecha_cierre,
            'monto_cierre_real' => $this->monto_cierre_real,
            'monto_cierre_sistema' => $this->monto_cierre_sistema,
            'diferencia' => $this->diferencia,
            'estado' => $this->estado,
            'observaciones' => $this->observaciones,
        ];
    }
}
