<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class PagoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'membresia_id' => $this->membresia_id,
            'socio_id' => $this->socio_id,
            'sede_id' => $this->sede_id,
            'empleado_id' => $this->empleado_id,
            'metodo_pago_id' => $this->metodo_pago_id,
            'promocion_id' => $this->promocion_id,
            'monto_bruto' => $this->monto_bruto,
            'monto_descuento' => $this->monto_descuento,
            'monto_matricula' => $this->monto_matricula,
            'monto_final' => $this->monto_final,
            'moneda' => $this->moneda,
            'es_pago_parcial' => $this->es_pago_parcial,
            'cuota_numero' => $this->cuota_numero,
            'cuota_total' => $this->cuota_total,
            'concepto' => $this->concepto,
            'numero_comprobante' => $this->numero_comprobante,
            'referencia_externa' => $this->referencia_externa,
            'estado' => $this->estado,
            'fecha_pago' => $this->fecha_pago,
            'fecha_vencimiento' => $this->fecha_vencimiento,
            'anulado_por_id' => $this->anulado_por_id,
            'motivo_anulacion' => $this->motivo_anulacion,
            'notas' => $this->notas,
        ];
    }
}
