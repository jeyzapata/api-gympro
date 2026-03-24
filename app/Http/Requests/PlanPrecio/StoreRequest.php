<?php

declare(strict_types=1);

namespace App\Http\Requests\PlanPrecio;

use App\DTOs\PlanPrecio\StorePlanPrecioPayload;
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
            'plan_id'          => ['required', 'integer', 'exists:planes,id'],
            'sede_id'          => ['nullable', 'integer', 'exists:sedes,id'],
            'precio'           => ['required', 'numeric', 'min:0'],
            'precio_matricula' => ['sometimes', 'numeric', 'min:0'],
            'moneda'           => ['sometimes', 'string', 'size:3'],
            'vigente_desde'    => ['required', 'date'],
            'vigente_hasta'    => ['nullable', 'date', 'after:vigente_desde'],
            'motivo_cambio'    => ['nullable', 'string', 'max:200'],
            'empleado_id'      => ['required', 'integer', 'exists:empleados,id'],
        ];
    }

    public function payload(): StorePlanPrecioPayload
    {
        return new StorePlanPrecioPayload(
            planId:          $this->integer('plan_id'),
            precio:          (string) $this->input('precio'),
            vigentDesde:     $this->string('vigente_desde')->toString(),
            empleadoId:      $this->integer('empleado_id'),
            sedeId:          $this->has('sede_id') ? $this->integer('sede_id') ?: null : null,
            precioMatricula: (string) ($this->input('precio_matricula') ?? '0'),
            moneda:          $this->string('moneda')->toString() ?: 'ARS',
            vigenteHasta:    $this->string('vigente_hasta')->toString() ?: null,
            motivoCambio:    $this->string('motivo_cambio')->toString() ?: null,
        );
    }
}
