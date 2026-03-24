<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class ReservaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'turno_clase_id' => $this->turno_clase_id,
            'socio_id' => $this->socio_id,
            'membresia_id' => $this->membresia_id,
            'estado' => $this->estado,
            'fecha_reserva' => $this->fecha_reserva,
            'fecha_cancelacion' => $this->fecha_cancelacion,
        ];
    }
}
