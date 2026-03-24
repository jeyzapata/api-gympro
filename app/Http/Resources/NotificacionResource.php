<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class NotificacionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'titulo' => $this->titulo,
            'cuerpo' => $this->cuerpo,
            'tipo' => $this->tipo,
            'leida' => $this->leida,
            'leida_at' => $this->leida_at,
            'data' => $this->data,
        ];
    }
}
