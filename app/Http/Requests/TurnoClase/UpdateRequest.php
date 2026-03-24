<?php

declare(strict_types=1);

namespace App\Http\Requests\TurnoClase;

use App\DTOs\TurnoClase\UpdateTurnoClasePayload;
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
            'clase_id'         => ['sometimes', 'integer', 'exists:clases,id'],
            'fecha'            => ['sometimes', 'date'],
            'hora_inicio'      => ['sometimes', 'date_format:H:i'],
            'hora_fin'         => ['sometimes', 'date_format:H:i', 'after:hora_inicio'],
            'instructor_id'    => ['nullable', 'integer', 'exists:empleados,id'],
            'estado'           => ['sometimes', 'string', 'in:programado,en_curso,finalizado,cancelado'],
            'capacidad_maxima' => ['nullable', 'integer', 'gt:0'],
            'notas'            => ['nullable', 'string'],
        ];
    }

    public function payload(): UpdateTurnoClasePayload
    {
        return new UpdateTurnoClasePayload(
            claseId:         $this->has('clase_id') ? $this->integer('clase_id') : null,
            fecha:           $this->has('fecha') ? $this->string('fecha')->toString() : null,
            horaInicio:      $this->has('hora_inicio') ? $this->string('hora_inicio')->toString() : null,
            horaFin:         $this->has('hora_fin') ? $this->string('hora_fin')->toString() : null,
            instructorId:    $this->has('instructor_id') ? $this->integer('instructor_id') ?: null : null,
            estado:          $this->has('estado') ? $this->string('estado')->toString() : null,
            capacidadMaxima: $this->has('capacidad_maxima') ? $this->integer('capacidad_maxima') ?: null : null,
            notas:           $this->has('notas') ? $this->string('notas')->toString() ?: null : null,
        );
    }
}
