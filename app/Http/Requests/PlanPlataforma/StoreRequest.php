<?php

declare(strict_types=1);

namespace App\Http\Requests\PlanPlataforma;

use App\DTOs\PlanPlataforma\StorePlanPlataformaPayload;
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
            'nombre'         => ['required', 'string', 'min:2', 'max:120'],
            'slug'           => ['required', 'string', 'max:80', 'unique:plan_plataformas,slug'],
            'precio_mensual' => ['required', 'numeric', 'min:0'],
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

    public function payload(): StorePlanPlataformaPayload
    {
        return new StorePlanPlataformaPayload(
            nombre:       $this->string('nombre')->toString(),
            slug:         $this->string('slug')->toString(),
            precioMensual: $this->string('precio_mensual')->toString(),
            descripcion:  $this->string('descripcion')->toString() ?: null,
            moneda:       $this->string('moneda')->toString() ?: 'ARS',
            maxSedes:     $this->integer('max_sedes', 1),
            maxEmpleados: $this->integer('max_empleados', 10),
            maxSocios:    $this->integer('max_socios', 200),
            features:     $this->input('features'),
            activo:       $this->boolean('activo', true),
            ordenDisplay: $this->integer('orden_display', 0),
        );
    }
}
