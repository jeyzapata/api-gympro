<?php

declare(strict_types=1);

namespace App\Http\Requests\Mantenimiento;

use App\DTOs\Mantenimiento\StoreMantenimientoPayload;
use App\Enums\EstadoMantenimiento;
use App\Enums\TipoMantenimiento;
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
            'equipo_id'        => ['required', 'integer', 'exists:equipos,id'],
            'empleado_id'      => ['nullable', 'integer', 'exists:empleados,id'],
            'tipo'             => ['required', Rule::enum(TipoMantenimiento::class)],
            'descripcion'      => ['required', 'string'],
            'fecha_programada' => ['required', 'date'],
            'fecha_realizado'  => ['nullable', 'date'],
            'costo'            => ['nullable', 'numeric', 'min:0'],
            'proveedor'        => ['nullable', 'string', 'max:150'],
            'estado'           => ['sometimes', Rule::enum(EstadoMantenimiento::class)],
            'proxima_revision' => ['nullable', 'date'],
        ];
    }

    public function payload(): StoreMantenimientoPayload
    {
        return new StoreMantenimientoPayload(
            equipoId:        $this->integer('equipo_id'),
            tipo:            $this->string('tipo')->toString(),
            descripcion:     $this->string('descripcion')->toString(),
            fechaProgramada: $this->string('fecha_programada')->toString(),
            empleadoId:      $this->has('empleado_id') ? $this->integer('empleado_id') ?: null : null,
            fechaRealizado:  $this->string('fecha_realizado')->toString() ?: null,
            costo:           $this->has('costo') ? $this->string('costo')->toString() ?: null : null,
            proveedor:       $this->string('proveedor')->toString() ?: null,
            estado:          $this->string('estado')->toString() ?: 'programado',
            proximaRevision: $this->string('proxima_revision')->toString() ?: null,
        );
    }
}
