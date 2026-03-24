<?php

declare(strict_types=1);

namespace App\Http\Requests\Mantenimiento;

use App\DTOs\Mantenimiento\UpdateMantenimientoPayload;
use App\Enums\EstadoMantenimiento;
use App\Enums\TipoMantenimiento;
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
            'equipo_id'        => ['sometimes', 'integer', 'exists:equipos,id'],
            'empleado_id'      => ['sometimes', 'nullable', 'integer', 'exists:empleados,id'],
            'tipo'             => ['sometimes', Rule::enum(TipoMantenimiento::class)],
            'descripcion'      => ['sometimes', 'string'],
            'fecha_programada' => ['sometimes', 'date'],
            'fecha_realizado'  => ['sometimes', 'nullable', 'date'],
            'costo'            => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'proveedor'        => ['sometimes', 'nullable', 'string', 'max:150'],
            'estado'           => ['sometimes', Rule::enum(EstadoMantenimiento::class)],
            'proxima_revision' => ['sometimes', 'nullable', 'date'],
        ];
    }

    public function payload(): UpdateMantenimientoPayload
    {
        return new UpdateMantenimientoPayload(
            equipoId:        $this->has('equipo_id') ? $this->integer('equipo_id') : null,
            empleadoId:      $this->has('empleado_id') ? ($this->integer('empleado_id') ?: null) : null,
            tipo:            $this->has('tipo') ? $this->string('tipo')->toString() : null,
            descripcion:     $this->has('descripcion') ? $this->string('descripcion')->toString() : null,
            fechaProgramada: $this->has('fecha_programada') ? $this->string('fecha_programada')->toString() : null,
            fechaRealizado:  $this->has('fecha_realizado') ? ($this->string('fecha_realizado')->toString() ?: null) : null,
            costo:           $this->has('costo') ? ($this->string('costo')->toString() ?: null) : null,
            proveedor:       $this->has('proveedor') ? ($this->string('proveedor')->toString() ?: null) : null,
            estado:          $this->has('estado') ? $this->string('estado')->toString() : null,
            proximaRevision: $this->has('proxima_revision') ? ($this->string('proxima_revision')->toString() ?: null) : null,
        );
    }
}
