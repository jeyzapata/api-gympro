<?php

declare(strict_types=1);

namespace App\Http\Requests\Plan;

use App\DTOs\Plan\StorePlanPayload;
use App\Enums\TipoPlan;
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
            'nombre'                  => ['required', 'string', 'min:2', 'max:100'],
            'descripcion'             => ['nullable', 'string'],
            'tipo'                    => ['required', 'string', Rule::enum(TipoPlan::class)],
            'duracion_dias'           => ['nullable', 'integer', 'min:1', 'required_if:tipo,fijo'],
            'cantidad_clases'         => ['nullable', 'integer', 'min:1', 'required_if:tipo,clases_sueltas'],
            'permite_congelamiento'   => ['sometimes', 'boolean'],
            'max_dias_congelamiento'  => ['sometimes', 'integer', 'min:0'],
            'max_veces_congelamiento' => ['sometimes', 'integer', 'min:0'],
            'permite_acceso_multisede' => ['sometimes', 'boolean'],
            'activo'                  => ['sometimes', 'boolean'],
            'orden_display'           => ['sometimes', 'integer', 'min:0', 'max:255'],
            'color_ui'                => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ];
    }

    public function payload(): StorePlanPayload
    {
        return new StorePlanPayload(
            nombre:                $this->string('nombre')->toString(),
            tipo:                  $this->string('tipo')->toString(),
            descripcion:           $this->string('descripcion')->toString() ?: null,
            duracionDias:          $this->has('duracion_dias') ? $this->integer('duracion_dias') : null,
            cantidadClases:        $this->has('cantidad_clases') ? $this->integer('cantidad_clases') : null,
            permiteCongelamiento:  $this->boolean('permite_congelamiento'),
            maxDiasCongelamiento:  $this->integer('max_dias_congelamiento', 0),
            maxVecesCongelamiento: $this->integer('max_veces_congelamiento', 0),
            permiteAccesoMultisede: $this->boolean('permite_acceso_multisede'),
            activo:                $this->boolean('activo', true),
            ordenDisplay:          $this->integer('orden_display', 0),
            colorUi:               $this->string('color_ui')->toString() ?: null,
        );
    }
}
