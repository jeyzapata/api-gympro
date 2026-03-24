<?php

declare(strict_types=1);

namespace App\Http\Requests\Promocion;

use App\DTOs\Promocion\StorePromocionPayload;
use App\Enums\AplicaPromocion;
use App\Enums\TipoDescuento;
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
            'codigo'          => ['nullable', 'string', 'max:50', 'unique:promocions,codigo'],
            'nombre'          => ['required', 'string', 'min:2', 'max:150'],
            'descripcion'     => ['nullable', 'string'],
            'tipo_descuento'  => ['required', 'string', Rule::enum(TipoDescuento::class)],
            'valor'           => ['required', 'numeric', 'min:0'],
            'aplica_a'        => ['required', 'string', Rule::enum(AplicaPromocion::class)],
            'plan_id'         => ['nullable', 'integer', 'exists:planes,id', 'required_if:aplica_a,plan_especifico'],
            'sede_id'         => ['nullable', 'integer', 'exists:sedes,id'],
            'usos_maximos'    => ['nullable', 'integer', 'min:1'],
            'un_uso_por_socio' => ['sometimes', 'boolean'],
            'vigente_desde'   => ['required', 'date'],
            'vigente_hasta'   => ['nullable', 'date', 'after:vigente_desde'],
            'activa'          => ['sometimes', 'boolean'],
        ];
    }

    public function payload(): StorePromocionPayload
    {
        return new StorePromocionPayload(
            nombre:         $this->string('nombre')->toString(),
            tipoDescuento:  $this->string('tipo_descuento')->toString(),
            valor:          $this->string('valor')->toString(),
            aplicaA:        $this->string('aplica_a')->toString(),
            vigente_desde:  $this->string('vigente_desde')->toString(),
            codigo:         $this->string('codigo')->toString() ?: null,
            descripcion:    $this->string('descripcion')->toString() ?: null,
            planId:         $this->has('plan_id') ? $this->integer('plan_id') ?: null : null,
            sedeId:         $this->has('sede_id') ? $this->integer('sede_id') ?: null : null,
            usosMaximos:    $this->has('usos_maximos') ? $this->integer('usos_maximos') ?: null : null,
            vigente_hasta:  $this->string('vigente_hasta')->toString() ?: null,
            usosActuales:   0,
            unUsoPorSocio:  $this->boolean('un_uso_por_socio', true),
            activa:         $this->boolean('activa', true),
        );
    }
}
