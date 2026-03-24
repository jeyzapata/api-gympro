<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class AsistenciaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'socio_id' => $this->socio_id,
            'sede_id' => $this->sede_id,
            'turno_clase_id' => $this->turno_clase_id,
            'membresia_id' => $this->membresia_id,
            'fecha_hora_ingreso' => $this->fecha_hora_ingreso,
            'fecha_hora_egreso' => $this->fecha_hora_egreso,
            'tipo' => $this->tipo,
        ];
    }
}
