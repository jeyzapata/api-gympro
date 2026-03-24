<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class EquipoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sede_id' => $this->sede_id,
            'categoria_equipo_id' => $this->categoria_equipo_id,
            'nombre' => $this->nombre,
            'marca' => $this->marca,
            'modelo' => $this->modelo,
            'numero_serie' => $this->numero_serie,
            'fecha_adquisicion' => $this->fecha_adquisicion,
            'valor_adquisicion' => $this->valor_adquisicion,
            'estado' => $this->estado,
            'ubicacion' => $this->ubicacion,
            'foto' => $this->foto,
            'notas' => $this->notas,
        ];
    }
}
