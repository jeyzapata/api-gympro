<?php

declare(strict_types=1);

namespace App\Http\Requests\PlanPrecio;

use App\DTOs\PlanPrecio\UpdatePlanPrecioPayload;
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
            'plan_id'          => ['sometimes', 'integer', 'exists:planes,id'],
            'sede_id'          => ['sometimes', 'nullable', 'integer', 'exists:sedes,id'],
            'precio'           => ['sometimes', 'numeric', 'min:0'],
            'precio_matricula' => ['sometimes', 'numeric', 'min:0'],
            'moneda'           => ['sometimes', 'string', 'size:3'],
            'vigente_desde'    => ['sometimes', 'date'],
            'vigente_hasta'    => ['sometimes', 'nullable', 'date', 'after:vigente_desde'],
            'motivo_cambio'    => ['sometimes', 'nullable', 'string', 'max:200'],
            'empleado_id'      => ['sometimes', 'integer', 'exists:empleados,id'],
        ];
    }

    public function payload(): UpdatePlanPrecioPayload
    {
        return new UpdatePlanPrecioPayload(
            planId:          $this->has('plan_id') ? $this->integer('plan_id') : null,
            sedeId:          $this->has('sede_id') ? $this->integer('sede_id') ?: null : null,
            precio:          $this->has('precio') ? (string) $this->input('precio') : null,
            precioMatricula: $this->has('precio_matricula') ? (string) $this->input('precio_matricula') : null,
            moneda:          $this->has('moneda') ? $this->string('moneda')->toString() : null,
            vigenteDesde:    $this->has('vigente_desde') ? $this->string('vigente_desde')->toString() : null,
            vigenteHasta:    $this->has('vigente_hasta') ? $this->string('vigente_hasta')->toString() ?: null : null,
            motivoCambio:    $this->has('motivo_cambio') ? $this->string('motivo_cambio')->toString() ?: null : null,
            empleadoId:      $this->has('empleado_id') ? $this->integer('empleado_id') : null,
        );
    }
}
