<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class PlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'tipo' => $this->tipo,
            'duracion_dias' => $this->duracion_dias,
            'cantidad_clases' => $this->cantidad_clases,
            'permite_congelamiento' => $this->permite_congelamiento,
            'max_dias_congelamiento' => $this->max_dias_congelamiento,
            'max_veces_congelamiento' => $this->max_veces_congelamiento,
            'permite_acceso_multisede' => $this->permite_acceso_multisede,
            'activo' => $this->activo,
            'orden_display' => $this->orden_display,
            'color_ui' => $this->color_ui,
        ];
    }
}
