<?php

declare(strict_types=1);

namespace App\Http\Requests\PlanNutricional;

use App\DTOs\PlanNutricional\UpdatePlanNutricionalPayload;
use App\Enums\ObjetivoNutricional;
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
            'socio_id'     => ['sometimes', 'integer', 'exists:socios,id'],
            'empleado_id'  => ['sometimes', 'integer', 'exists:empleados,id'],
            'nombre'       => ['sometimes', 'string', 'max:150'],
            'objetivo'     => ['sometimes', 'string', Rule::enum(ObjetivoNutricional::class)],
            'descripcion'  => ['sometimes', 'nullable', 'string'],
            'fecha_inicio' => ['sometimes', 'date'],
            'fecha_fin'    => ['sometimes', 'nullable', 'date', 'after:fecha_inicio'],
            'activo'       => ['sometimes', 'boolean'],
        ];
    }

    public function payload(): UpdatePlanNutricionalPayload
    {
        return new UpdatePlanNutricionalPayload(
            socioId:     $this->has('socio_id') ? $this->integer('socio_id') : null,
            empleadoId:  $this->has('empleado_id') ? $this->integer('empleado_id') : null,
            nombre:      $this->has('nombre') ? $this->string('nombre')->toString() : null,
            objetivo:    $this->has('objetivo') ? $this->string('objetivo')->toString() : null,
            descripcion: $this->has('descripcion') ? $this->string('descripcion')->toString() ?: null : null,
            fechaInicio: $this->has('fecha_inicio') ? $this->string('fecha_inicio')->toString() : null,
            fechaFin:    $this->has('fecha_fin') ? $this->string('fecha_fin')->toString() ?: null : null,
            activo:      $this->has('activo') ? $this->boolean('activo') : null,
        );
    }
}
