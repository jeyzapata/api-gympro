<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class DeudaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'socio_id' => $this->socio_id,
            'membresia_id' => $this->membresia_id,
            'sede_id' => $this->sede_id,
            'concepto' => $this->concepto,
            'monto' => $this->monto,
            'fecha_generacion' => $this->fecha_generacion,
            'fecha_vencimiento' => $this->fecha_vencimiento,
            'estado' => $this->estado,
            'pago_id' => $this->pago_id,
        ];
    }
}
