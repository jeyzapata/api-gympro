<?php

declare(strict_types=1);

namespace App\Http\Requests\Pago;

use App\DTOs\Pago\UpdatePagoPayload;
use Illuminate\Foundation\Http\FormRequest;

final class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'membresia_id'        => ['sometimes', 'nullable', 'integer', 'exists:membresias,id'],
            'socio_id'            => ['sometimes', 'integer', 'exists:socios,id'],
            'sede_id'             => ['sometimes', 'integer', 'exists:sedes,id'],
            'empleado_id'         => ['sometimes', 'integer', 'exists:empleados,id'],
            'metodo_pago_id'      => ['sometimes', 'integer', 'exists:metodo_pagos,id'],
            'promocion_id'        => ['sometimes', 'nullable', 'integer', 'exists:promociones,id'],
            'monto_bruto'         => ['sometimes', 'numeric', 'min:0'],
            'monto_descuento'     => ['sometimes', 'numeric', 'min:0'],
            'monto_matricula'     => ['sometimes', 'numeric', 'min:0'],
            'monto_final'         => ['sometimes', 'numeric', 'min:0'],
            'moneda'              => ['sometimes', 'string', 'max:3'],
            'es_pago_parcial'     => ['sometimes', 'boolean'],
            'cuota_numero'        => ['sometimes', 'nullable', 'integer', 'gt:0', 'required_with:cuota_total'],
            'cuota_total'         => ['sometimes', 'nullable', 'integer', 'gt:0'],
            'concepto'            => ['sometimes', 'string', 'max:200'],
            'numero_comprobante'  => ['sometimes', 'nullable', 'string', 'max:80'],
            'referencia_externa'  => ['sometimes', 'nullable', 'string', 'max:150'],
            'estado'              => ['sometimes', 'string', 'in:pendiente,pagado,anulado,reembolsado'],
            'fecha_pago'          => ['sometimes', 'date'],
            'fecha_vencimiento'   => ['sometimes', 'nullable', 'date'],
            'anulado_por_id'      => ['sometimes', 'nullable', 'integer', 'gt:0'],
            'motivo_anulacion'    => ['sometimes', 'nullable', 'string', 'max:200'],
            'notas'               => ['sometimes', 'nullable', 'string'],
        ];
    }

    public function payload(): UpdatePagoPayload
    {
        return new UpdatePagoPayload(
            socioId:           $this->has('socio_id') ? $this->integer('socio_id') : null,
            sedeId:            $this->has('sede_id') ? $this->integer('sede_id') : null,
            empleadoId:        $this->has('empleado_id') ? $this->integer('empleado_id') : null,
            metodoPagoId:      $this->has('metodo_pago_id') ? $this->integer('metodo_pago_id') : null,
            membresiaId:       $this->has('membresia_id') ? ($this->integer('membresia_id') ?: null) : null,
            promocionId:       $this->has('promocion_id') ? ($this->integer('promocion_id') ?: null) : null,
            montoBruto:        $this->has('monto_bruto') ? $this->string('monto_bruto')->toString() : null,
            montoDescuento:    $this->has('monto_descuento') ? $this->string('monto_descuento')->toString() : null,
            montoMatricula:    $this->has('monto_matricula') ? $this->string('monto_matricula')->toString() : null,
            montoFinal:        $this->has('monto_final') ? $this->string('monto_final')->toString() : null,
            moneda:            $this->has('moneda') ? $this->string('moneda')->toString() : null,
            esPagoParcial:     $this->has('es_pago_parcial') ? $this->boolean('es_pago_parcial') : null,
            cuotaNumero:       $this->has('cuota_numero') ? ($this->integer('cuota_numero') ?: null) : null,
            cuotaTotal:        $this->has('cuota_total') ? ($this->integer('cuota_total') ?: null) : null,
            concepto:          $this->has('concepto') ? $this->string('concepto')->toString() : null,
            numeroComprobante: $this->has('numero_comprobante') ? ($this->string('numero_comprobante')->toString() ?: null) : null,
            referenciaExterna: $this->has('referencia_externa') ? ($this->string('referencia_externa')->toString() ?: null) : null,
            estado:            $this->has('estado') ? $this->string('estado')->toString() : null,
            fechaPago:         $this->has('fecha_pago') ? $this->string('fecha_pago')->toString() : null,
            fechaVencimiento:  $this->has('fecha_vencimiento') ? ($this->string('fecha_vencimiento')->toString() ?: null) : null,
            anuladoPorId:      $this->has('anulado_por_id') ? ($this->integer('anulado_por_id') ?: null) : null,
            motivoAnulacion:   $this->has('motivo_anulacion') ? ($this->string('motivo_anulacion')->toString() ?: null) : null,
            notas:             $this->has('notas') ? ($this->string('notas')->toString() ?: null) : null,
        );
    }
}
