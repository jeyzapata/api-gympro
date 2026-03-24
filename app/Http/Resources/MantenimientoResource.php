<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class MantenimientoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'equipo_id' => $this->equipo_id,
            'empleado_id' => $this->empleado_id,
            'tipo' => $this->tipo,
            'descripcion' => $this->descripcion,
            'fecha_programada' => $this->fecha_programada,
            'fecha_realizado' => $this->fecha_realizado,
            'costo' => $this->costo,
            'proveedor' => $this->proveedor,
            'estado' => $this->estado,
            'proxima_revision' => $this->proxima_revision,
        ];
    }
}
