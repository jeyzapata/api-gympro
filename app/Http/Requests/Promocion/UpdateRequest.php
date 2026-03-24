<?php

declare(strict_types=1);

namespace App\Http\Requests\Promocion;

use App\DTOs\Promocion\UpdatePromocionPayload;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo'          => ['sometimes', 'nullable', 'string', 'max:50', Rule::unique('promocions', 'codigo')->ignore($this->route('promocion'))],
            'nombre'          => ['sometimes', 'string', 'min:2', 'max:150'],
            'descripcion'     => ['sometimes', 'nullable', 'string'],
            'tipo_descuento'  => ['sometimes', 'string', 'in:porcentaje,monto_fijo,meses_gratis'],
            'valor'           => ['sometimes', 'numeric', 'min:0'],
            'aplica_a'        => ['sometimes', 'string', 'in:todos,plan_especifico,primera_membresia'],
            'plan_id'         => ['sometimes', 'nullable', 'integer', 'exists:planes,id'],
            'sede_id'         => ['sometimes', 'nullable', 'integer', 'exists:sedes,id'],
            'usos_maximos'    => ['sometimes', 'nullable', 'integer', 'min:1'],
            'un_uso_por_socio' => ['sometimes', 'boolean'],
            'vigente_desde'   => ['sometimes', 'date'],
            'vigente_hasta'   => ['sometimes', 'nullable', 'date', 'after:vigente_desde'],
            'activa'          => ['sometimes', 'boolean'],
        ];
    }

    public function payload(): UpdatePromocionPayload
    {
        return new UpdatePromocionPayload(
            codigo:        $this->has('codigo') ? $this->string('codigo')->toString() ?: null : null,
            nombre:        $this->has('nombre') ? $this->string('nombre')->toString() : null,
            descripcion:   $this->has('descripcion') ? $this->string('descripcion')->toString() ?: null : null,
            tipoDescuento: $this->has('tipo_descuento') ? $this->string('tipo_descuento')->toString() : null,
            valor:         $this->has('valor') ? $this->string('valor')->toString() : null,
            aplicaA:       $this->has('aplica_a') ? $this->string('aplica_a')->toString() : null,
            planId:        $this->has('plan_id') ? $this->integer('plan_id') ?: null : null,
            sedeId:        $this->has('sede_id') ? $this->integer('sede_id') ?: null : null,
            usosMaximos:   $this->has('usos_maximos') ? $this->integer('usos_maximos') ?: null : null,
            usosActuales:  $this->has('usos_actuales') ? $this->integer('usos_actuales') : null,
            unUsoPorSocio: $this->has('un_uso_por_socio') ? $this->boolean('un_uso_por_socio') : null,
            vigente_desde: $this->has('vigente_desde') ? $this->string('vigente_desde')->toString() : null,
            vigente_hasta: $this->has('vigente_hasta') ? $this->string('vigente_hasta')->toString() ?: null : null,
            activa:        $this->has('activa') ? $this->boolean('activa') : null,
        );
    }
}
