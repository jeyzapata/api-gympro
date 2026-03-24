<?php

declare(strict_types=1);

namespace App\Http\Requests\Asistencia;

use App\DTOs\Asistencia\StoreAsistenciaPayload;
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
            'socio_id'            => ['required', 'integer', 'exists:socios,id'],
            'sede_id'             => ['required', 'integer', 'exists:sedes,id'],
            'turno_clase_id'      => ['nullable', 'integer', 'exists:turno_clases,id', 'required_if:tipo,clase'],
            'membresia_id'        => ['nullable', 'integer', 'exists:membresias,id'],
            'fecha_hora_ingreso'  => ['required', 'date'],
            'fecha_hora_egreso'   => ['nullable', 'date', 'after:fecha_hora_ingreso'],
            'tipo'                => ['required', 'string', 'in:clase,acceso_libre'],
        ];
    }

    public function payload(): StoreAsistenciaPayload
    {
        return new StoreAsistenciaPayload(
            socioId:          $this->integer('socio_id'),
            sedeId:           $this->integer('sede_id'),
            fechaHoraIngreso: $this->string('fecha_hora_ingreso')->toString(),
            tipo:             $this->string('tipo')->toString(),
            turnoClaseId:     $this->has('turno_clase_id') ? $this->integer('turno_clase_id') ?: null : null,
            membresiaId:      $this->has('membresia_id') ? $this->integer('membresia_id') ?: null : null,
            fechaHoraEgreso:  $this->has('fecha_hora_egreso') ? $this->string('fecha_hora_egreso')->toString() ?: null : null,
        );
    }
}
