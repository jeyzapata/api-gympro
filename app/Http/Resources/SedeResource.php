<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class SedeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'direccion' => $this->direccion,
            'ciudad' => $this->ciudad,
            'provincia' => $this->provincia,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'horario_apertura' => $this->horario_apertura,
            'horario_cierre' => $this->horario_cierre,
            'activa' => $this->activa,
        ];
    }
}
