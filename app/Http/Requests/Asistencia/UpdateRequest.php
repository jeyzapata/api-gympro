<?php

declare(strict_types=1);

namespace App\Http\Requests\Asistencia;

use App\DTOs\Asistencia\UpdateAsistenciaPayload;
use App\Enums\TipoAsistencia;
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
            'socio_id'            => ['sometimes', 'integer', 'exists:socios,id'],
            'sede_id'             => ['sometimes', 'integer', 'exists:sedes,id'],
            'turno_clase_id'      => ['sometimes', 'nullable', 'integer', 'exists:turno_clases,id'],
            'membresia_id'        => ['sometimes', 'nullable', 'integer', 'exists:membresias,id'],
            'fecha_hora_ingreso'  => ['sometimes', 'date'],
            'fecha_hora_egreso'   => ['sometimes', 'nullable', 'date', 'after:fecha_hora_ingreso'],
            'tipo'                => ['sometimes', 'string', Rule::enum(TipoAsistencia::class)],
        ];
    }

    public function payload(): UpdateAsistenciaPayload
    {
        return new UpdateAsistenciaPayload(
            socioId:          $this->has('socio_id') ? $this->integer('socio_id') : null,
            sedeId:           $this->has('sede_id') ? $this->integer('sede_id') : null,
            turnoClaseId:     $this->has('turno_clase_id') ? $this->integer('turno_clase_id') ?: null : null,
            membresiaId:      $this->has('membresia_id') ? $this->integer('membresia_id') ?: null : null,
            fechaHoraIngreso: $this->has('fecha_hora_ingreso') ? $this->string('fecha_hora_ingreso')->toString() : null,
            fechaHoraEgreso:  $this->has('fecha_hora_egreso') ? $this->string('fecha_hora_egreso')->toString() ?: null : null,
            tipo:             $this->has('tipo') ? $this->string('tipo')->toString() : null,
        );
    }
}
