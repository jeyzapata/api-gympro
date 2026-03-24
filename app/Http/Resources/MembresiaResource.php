<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class MembresiaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'socio_id' => $this->socio_id,
            'plan_id' => $this->plan_id,
            'plan_precio_id' => $this->plan_precio_id,
            'sede_id' => $this->sede_id,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'clases_restantes' => $this->clases_restantes,
            'estado' => $this->estado,
            'fecha_congelamiento' => $this->fecha_congelamiento,
            'fecha_descongelamiento' => $this->fecha_descongelamiento,
            'dias_congelados_usados' => $this->dias_congelados_usados,
            'veces_congelado' => $this->veces_congelado,
            'auto_renovar' => $this->auto_renovar,
            'notas' => $this->notas,
        ];
    }
}
