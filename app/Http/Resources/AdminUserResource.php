<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class AdminUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'nombre'       => $this->nombre,
            'apellido'     => $this->apellido,
            'email'        => $this->email,
            'activo'       => $this->activo,
            'ultimo_login' => $this->ultimo_login?->toISOString(),
            'created_at'   => $this->created_at?->toISOString(),
        ];
    }
}
