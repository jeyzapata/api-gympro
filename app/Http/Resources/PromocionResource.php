<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class PromocionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'codigo' => $this->codigo,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'tipo_descuento' => $this->tipo_descuento,
            'valor' => $this->valor,
            'aplica_a' => $this->aplica_a,
            'plan_id' => $this->plan_id,
            'sede_id' => $this->sede_id,
            'usos_maximos' => $this->usos_maximos,
            'usos_actuales' => $this->usos_actuales,
            'un_uso_por_socio' => $this->un_uso_por_socio,
            'vigente_desde' => $this->vigente_desde,
            'vigente_hasta' => $this->vigente_hasta,
            'activa' => $this->activa,
        ];
    }
}
