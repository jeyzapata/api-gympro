<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class TurnoClaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'clase_id' => $this->clase_id,
            'fecha' => $this->fecha,
            'hora_inicio' => $this->hora_inicio,
            'hora_fin' => $this->hora_fin,
            'instructor_id' => $this->instructor_id,
            'estado' => $this->estado,
            'capacidad_maxima' => $this->capacidad_maxima,
            'notas' => $this->notas,
        ];
    }
}
