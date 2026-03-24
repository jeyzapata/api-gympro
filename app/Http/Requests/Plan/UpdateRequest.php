<?php

declare(strict_types=1);

namespace App\Http\Requests\Plan;

use App\DTOs\Plan\UpdatePlanPayload;
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
            'nombre'                  => ['sometimes', 'string', 'min:2', 'max:100'],
            'descripcion'             => ['sometimes', 'nullable', 'string'],
            'tipo'                    => ['sometimes', 'string', 'in:fijo,pase_dia,clases_sueltas'],
            'duracion_dias'           => ['sometimes', 'nullable', 'integer', 'min:1', 'required_if:tipo,fijo'],
            'cantidad_clases'         => ['sometimes', 'nullable', 'integer', 'min:1', 'required_if:tipo,clases_sueltas'],
            'permite_congelamiento'   => ['sometimes', 'boolean'],
            'max_dias_congelamiento'  => ['sometimes', 'integer', 'min:0'],
            'max_veces_congelamiento' => ['sometimes', 'integer', 'min:0'],
            'permite_acceso_multisede' => ['sometimes', 'boolean'],
            'activo'                  => ['sometimes', 'boolean'],
            'orden_display'           => ['sometimes', 'integer', 'min:0', 'max:255'],
            'color_ui'                => ['sometimes', 'nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ];
    }

    public function payload(): UpdatePlanPayload
    {
        return new UpdatePlanPayload(
            nombre:                $this->has('nombre') ? $this->string('nombre')->toString() : null,
            descripcion:           $this->has('descripcion') ? ($this->string('descripcion')->toString() ?: null) : null,
            tipo:                  $this->has('tipo') ? $this->string('tipo')->toString() : null,
            duracionDias:          $this->has('duracion_dias') ? $this->integer('duracion_dias') : null,
            cantidadClases:        $this->has('cantidad_clases') ? $this->integer('cantidad_clases') : null,
            permiteCongelamiento:  $this->has('permite_congelamiento') ? $this->boolean('permite_congelamiento') : null,
            maxDiasCongelamiento:  $this->has('max_dias_congelamiento') ? $this->integer('max_dias_congelamiento') : null,
            maxVecesCongelamiento: $this->has('max_veces_congelamiento') ? $this->integer('max_veces_congelamiento') : null,
            permiteAccesoMultisede: $this->has('permite_acceso_multisede') ? $this->boolean('permite_acceso_multisede') : null,
            activo:                $this->has('activo') ? $this->boolean('activo') : null,
            ordenDisplay:          $this->has('orden_display') ? $this->integer('orden_display') : null,
            colorUi:               $this->has('color_ui') ? ($this->string('color_ui')->toString() ?: null) : null,
        );
    }
}
