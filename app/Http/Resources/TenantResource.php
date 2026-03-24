<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class TenantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'nombre' => $this->nombre,
            'email_admin' => $this->email_admin,
            'telefono' => $this->telefono,
            'logo' => $this->logo,
            'schema_name' => $this->schema_name,
            'plan_suscripcion' => $this->plan_suscripcion,
            'trial_ends_at' => $this->trial_ends_at,
            'suscripcion_activa' => $this->suscripcion_activa,
            'max_sedes' => $this->max_sedes,
            'max_empleados' => $this->max_empleados,
            'max_socios' => $this->max_socios,
            'datos_fiscales' => $this->datos_fiscales,
        ];
    }
}
