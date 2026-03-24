<?php

declare(strict_types=1);

namespace App\Http\Requests\PlanPlataforma;

use App\DTOs\PlanPlataforma\UpdatePlanPlataformaPayload;
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
            'nombre'         => ['sometimes', 'string', 'min:2', 'max:120'],
            'slug'           => ['sometimes', 'string', 'max:80', Rule::unique('plan_plataformas', 'slug')->ignore($this->route('planes_plataforma'))],
            'precio_mensual' => ['sometimes', 'numeric', 'min:0'],
            'descripcion'    => ['nullable', 'string', 'max:500'],
            'moneda'         => ['sometimes', 'string', 'max:3'],
            'max_sedes'      => ['sometimes', 'integer', 'min:1'],
            'max_empleados'  => ['sometimes', 'integer', 'min:1'],
            'max_socios'     => ['sometimes', 'integer', 'min:1'],
            'features'       => ['nullable', 'array'],
            'activo'         => ['sometimes', 'boolean'],
            'orden_display'  => ['sometimes', 'integer', 'min:0'],
        ];
    }

    public function payload(): UpdatePlanPlataformaPayload
    {
        return new UpdatePlanPlataformaPayload(
            nombre:       $this->has('nombre') ? $this->string('nombre')->toString() : null,
            slug:         $this->has('slug') ? $this->string('slug')->toString() : null,
            precioMensual: $this->has('precio_mensual') ? $this->string('precio_mensual')->toString() : null,
            descripcion:  $this->has('descripcion') ? $this->string('descripcion')->toString() ?: null : null,
            moneda:       $this->has('moneda') ? $this->string('moneda')->toString() : null,
            maxSedes:     $this->has('max_sedes') ? $this->integer('max_sedes') : null,
            maxEmpleados: $this->has('max_empleados') ? $this->integer('max_empleados') : null,
            maxSocios:    $this->has('max_socios') ? $this->integer('max_socios') : null,
            features:     $this->has('features') ? $this->input('features') : null,
            activo:       $this->has('activo') ? $this->boolean('activo') : null,
            ordenDisplay: $this->has('orden_display') ? $this->integer('orden_display') : null,
        );
    }
}
