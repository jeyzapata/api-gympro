<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class ClaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sede_id' => $this->sede_id,
            'tipo_clase_id' => $this->tipo_clase_id,
            'empleado_id' => $this->empleado_id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'dia_semana' => $this->dia_semana,
            'hora_inicio' => $this->hora_inicio,
            'hora_fin' => $this->hora_fin,
            'capacidad_maxima' => $this->capacidad_maxima,
            'es_recurrente' => $this->es_recurrente,
            'fecha_inicio_vigencia' => $this->fecha_inicio_vigencia,
            'fecha_fin_vigencia' => $this->fecha_fin_vigencia,
            'activa' => $this->activa,
        ];
    }
}
