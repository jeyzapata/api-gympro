<?php

declare(strict_types=1);

namespace App\Http\Requests\Pago;

use App\DTOs\Pago\StorePagoPayload;
use Illuminate\Foundation\Http\FormRequest;

final class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'membresia_id'        => ['nullable', 'integer', 'exists:membresias,id'],
            'socio_id'            => ['required', 'integer', 'exists:socios,id'],
            'sede_id'             => ['required', 'integer', 'exists:sedes,id'],
            'empleado_id'         => ['required', 'integer', 'exists:empleados,id'],
            'metodo_pago_id'      => ['required', 'integer', 'exists:metodo_pagos,id'],
            'promocion_id'        => ['nullable', 'integer', 'exists:promociones,id'],
            'monto_bruto'         => ['required', 'numeric', 'min:0'],
            'monto_descuento'     => ['sometimes', 'numeric', 'min:0'],
            'monto_matricula'     => ['sometimes', 'numeric', 'min:0'],
            'monto_final'         => ['required', 'numeric', 'min:0'],
            'moneda'              => ['sometimes', 'string', 'max:3'],
            'es_pago_parcial'     => ['sometimes', 'boolean'],
            'cuota_numero'        => ['nullable', 'integer', 'gt:0', 'required_with:cuota_total'],
            'cuota_total'         => ['nullable', 'integer', 'gt:0'],
            'concepto'            => ['required', 'string', 'max:200'],
            'numero_comprobante'  => ['nullable', 'string', 'max:80'],
            'referencia_externa'  => ['nullable', 'string', 'max:150'],
            'estado'              => ['sometimes', 'string', 'in:pendiente,pagado,anulado,reembolsado'],
            'fecha_pago'          => ['required', 'date'],
            'fecha_vencimiento'   => ['nullable', 'date'],
            'anulado_por_id'      => ['nullable', 'integer', 'gt:0'],
            'motivo_anulacion'    => ['nullable', 'string', 'max:200'],
            'notas'               => ['nullable', 'string'],
        ];
    }

    public function payload(): StorePagoPayload
    {
        return new StorePagoPayload(
            socioId:           $this->integer('socio_id'),
            sedeId:            $this->integer('sede_id'),
            empleadoId:        $this->integer('empleado_id'),
            metodoPagoId:      $this->integer('metodo_pago_id'),
            montoBruto:        $this->string('monto_bruto')->toString(),
            montoFinal:        $this->string('monto_final')->toString(),
            concepto:          $this->string('concepto')->toString(),
            fechaPago:         $this->string('fecha_pago')->toString(),
            membresiaId:       $this->has('membresia_id') ? ($this->integer('membresia_id') ?: null) : null,
            promocionId:       $this->has('promocion_id') ? ($this->integer('promocion_id') ?: null) : null,
            montoDescuento:    $this->string('monto_descuento')->toString() ?: '0',
            montoMatricula:    $this->string('monto_matricula')->toString() ?: '0',
            moneda:            $this->string('moneda')->toString() ?: 'ARS',
            esPagoParcial:     $this->boolean('es_pago_parcial', false),
            cuotaNumero:       $this->has('cuota_numero') ? ($this->integer('cuota_numero') ?: null) : null,
            cuotaTotal:        $this->has('cuota_total') ? ($this->integer('cuota_total') ?: null) : null,
            numeroComprobante: $this->string('numero_comprobante')->toString() ?: null,
            referenciaExterna: $this->string('referencia_externa')->toString() ?: null,
            estado:            $this->string('estado')->toString() ?: 'pagado',
            fechaVencimiento:  $this->string('fecha_vencimiento')->toString() ?: null,
            anuladoPorId:      $this->has('anulado_por_id') ? ($this->integer('anulado_por_id') ?: null) : null,
            motivoAnulacion:   $this->string('motivo_anulacion')->toString() ?: null,
            notas:             $this->string('notas')->toString() ?: null,
        );
    }
}
