<?php

declare(strict_types=1);

namespace App\Http\Requests\Membresia;

use App\DTOs\Membresia\StoreMembresiaPayload;
use App\Enums\EstadoMembresia;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'socio_id'                => ['required', 'integer', 'exists:socios,id'],
            'plan_id'                 => ['required', 'integer', 'exists:planes,id'],
            'plan_precio_id'          => ['required', 'integer', 'exists:plan_precios,id'],
            'sede_id'                 => ['required', 'integer', 'exists:sedes,id'],
            'fecha_inicio'            => ['required', 'date'],
            'fecha_fin'               => ['nullable', 'date', 'after:fecha_inicio'],
            'clases_restantes'        => ['nullable', 'integer', 'min:0'],
            'estado'                  => ['sometimes', 'string', Rule::enum(EstadoMembresia::class)],
            'fecha_congelamiento'     => ['nullable', 'date'],
            'fecha_descongelamiento'  => ['nullable', 'date', 'after:fecha_congelamiento'],
            'dias_congelados_usados'  => ['sometimes', 'integer', 'min:0'],
            'veces_congelado'         => ['sometimes', 'integer', 'min:0'],
            'auto_renovar'            => ['sometimes', 'boolean'],
            'notas'                   => ['nullable', 'string'],
        ];
    }

    public function payload(): StoreMembresiaPayload
    {
        return new StoreMembresiaPayload(
            socioId:               $this->integer('socio_id'),
            planId:                $this->integer('plan_id'),
            planPrecioId:          $this->integer('plan_precio_id'),
            sedeId:                $this->integer('sede_id'),
            fechaInicio:           $this->string('fecha_inicio')->toString(),
            fechaFin:              $this->string('fecha_fin')->toString() ?: null,
            clasesRestantes:       $this->has('clases_restantes') ? $this->integer('clases_restantes') ?: null : null,
            estado:                $this->string('estado')->toString() ?: 'activa',
            fechaCongelamiento:    $this->string('fecha_congelamiento')->toString() ?: null,
            fechaDescongelamiento: $this->string('fecha_descongelamiento')->toString() ?: null,
            diasCongeladosUsados:  $this->integer('dias_congelados_usados', 0),
            vecesCongelado:        $this->integer('veces_congelado', 0),
            autoRenovar:           $this->boolean('auto_renovar', false),
            notas:                 $this->string('notas')->toString() ?: null,
        );
    }
}
