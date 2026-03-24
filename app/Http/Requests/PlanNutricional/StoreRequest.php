<?php

declare(strict_types=1);

namespace App\Http\Requests\PlanNutricional;

use App\DTOs\PlanNutricional\StorePlanNutricionalPayload;
use App\Enums\ObjetivoNutricional;
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
            'socio_id'     => ['required', 'integer', 'exists:socios,id'],
            'empleado_id'  => ['required', 'integer', 'exists:empleados,id'],
            'nombre'       => ['required', 'string', 'max:150'],
            'objetivo'     => ['required', 'string', Rule::enum(ObjetivoNutricional::class)],
            'descripcion'  => ['nullable', 'string'],
            'fecha_inicio' => ['required', 'date'],
            'fecha_fin'    => ['nullable', 'date', 'after:fecha_inicio'],
            'activo'       => ['sometimes', 'boolean'],
        ];
    }

    public function payload(): StorePlanNutricionalPayload
    {
        return new StorePlanNutricionalPayload(
            socioId:     $this->integer('socio_id'),
            empleadoId:  $this->integer('empleado_id'),
            nombre:      $this->string('nombre')->toString(),
            objetivo:    $this->string('objetivo')->toString(),
            fechaInicio: $this->string('fecha_inicio')->toString(),
            descripcion: $this->has('descripcion') ? $this->string('descripcion')->toString() ?: null : null,
            fechaFin:    $this->has('fecha_fin') ? $this->string('fecha_fin')->toString() ?: null : null,
            activo:      $this->boolean('activo', true),
        );
    }
}
