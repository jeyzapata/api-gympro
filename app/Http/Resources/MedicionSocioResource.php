<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class MedicionSocioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'socio_id' => $this->socio_id,
            'empleado_id' => $this->empleado_id,
            'fecha' => $this->fecha,
            'peso_kg' => $this->peso_kg,
            'altura_cm' => $this->altura_cm,
            'imc' => $this->imc,
            'porcentaje_grasa' => $this->porcentaje_grasa,
            'masa_muscular_kg' => $this->masa_muscular_kg,
            'cintura_cm' => $this->cintura_cm,
            'cadera_cm' => $this->cadera_cm,
            'pecho_cm' => $this->pecho_cm,
            'notas' => $this->notas,
        ];
    }
}
