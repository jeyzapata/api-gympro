<?php

declare(strict_types=1);

namespace App\Http\Requests\Membresia;

use App\DTOs\Membresia\UpdateMembresiaPayload;
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
            'socio_id'                => ['sometimes', 'integer', 'exists:socios,id'],
            'plan_id'                 => ['sometimes', 'integer', 'exists:planes,id'],
            'plan_precio_id'          => ['sometimes', 'integer', 'exists:plan_precios,id'],
            'sede_id'                 => ['sometimes', 'integer', 'exists:sedes,id'],
            'fecha_inicio'            => ['sometimes', 'date'],
            'fecha_fin'               => ['sometimes', 'nullable', 'date', 'after:fecha_inicio'],
            'clases_restantes'        => ['sometimes', 'nullable', 'integer', 'min:0'],
            'estado'                  => ['sometimes', 'string', 'in:activa,vencida,congelada,cancelada,pendiente_pago'],
            'fecha_congelamiento'     => ['sometimes', 'nullable', 'date'],
            'fecha_descongelamiento'  => ['sometimes', 'nullable', 'date', 'after:fecha_congelamiento'],
            'dias_congelados_usados'  => ['sometimes', 'integer', 'min:0'],
            'veces_congelado'         => ['sometimes', 'integer', 'min:0'],
            'auto_renovar'            => ['sometimes', 'boolean'],
            'notas'                   => ['sometimes', 'nullable', 'string'],
        ];
    }

    public function payload(): UpdateMembresiaPayload
    {
        return new UpdateMembresiaPayload(
            socioId:               $this->has('socio_id') ? $this->integer('socio_id') : null,
            planId:                $this->has('plan_id') ? $this->integer('plan_id') : null,
            planPrecioId:          $this->has('plan_precio_id') ? $this->integer('plan_precio_id') : null,
            sedeId:                $this->has('sede_id') ? $this->integer('sede_id') : null,
            fechaInicio:           $this->has('fecha_inicio') ? $this->string('fecha_inicio')->toString() : null,
            fechaFin:              $this->has('fecha_fin') ? ($this->string('fecha_fin')->toString() ?: null) : null,
            clasesRestantes:       $this->has('clases_restantes') ? ($this->integer('clases_restantes') ?: null) : null,
            estado:                $this->has('estado') ? $this->string('estado')->toString() : null,
            fechaCongelamiento:    $this->has('fecha_congelamiento') ? ($this->string('fecha_congelamiento')->toString() ?: null) : null,
            fechaDescongelamiento: $this->has('fecha_descongelamiento') ? ($this->string('fecha_descongelamiento')->toString() ?: null) : null,
            diasCongeladosUsados:  $this->has('dias_congelados_usados') ? $this->integer('dias_congelados_usados') : null,
            vecesCongelado:        $this->has('veces_congelado') ? $this->integer('veces_congelado') : null,
            autoRenovar:           $this->has('auto_renovar') ? $this->boolean('auto_renovar') : null,
            notas:                 $this->has('notas') ? ($this->string('notas')->toString() ?: null) : null,
        );
    }
}
