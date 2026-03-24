<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'email'             => $this->email,
            'userable_type'     => $this->userable_type,
            'userable_id'       => $this->userable_id,
            'email_verified_at' => $this->email_verified_at,
            'ultimo_login'      => $this->ultimo_login,
            'activo'            => $this->activo,
        ];
    }
}
