<?php

declare(strict_types=1);

namespace App\Http\Requests\TurnoClase;

use App\DTOs\TurnoClase\StoreTurnoClasePayload;
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
            'clase_id'         => ['required', 'integer', 'exists:clases,id'],
            'fecha'            => ['required', 'date'],
            'hora_inicio'      => ['required', 'date_format:H:i'],
            'hora_fin'         => ['required', 'date_format:H:i', 'after:hora_inicio'],
            'instructor_id'    => ['nullable', 'integer', 'exists:empleados,id'],
            'estado'           => ['sometimes', 'string', 'in:programado,en_curso,finalizado,cancelado'],
            'capacidad_maxima' => ['nullable', 'integer', 'gt:0'],
            'notas'            => ['nullable', 'string'],
        ];
    }

    public function payload(): StoreTurnoClasePayload
    {
        return new StoreTurnoClasePayload(
            claseId:         $this->integer('clase_id'),
            fecha:           $this->string('fecha')->toString(),
            horaInicio:      $this->string('hora_inicio')->toString(),
            horaFin:         $this->string('hora_fin')->toString(),
            instructorId:    $this->has('instructor_id') ? $this->integer('instructor_id') ?: null : null,
            estado:          $this->string('estado')->toString() ?: 'programado',
            capacidadMaxima: $this->has('capacidad_maxima') ? $this->integer('capacidad_maxima') ?: null : null,
            notas:           $this->string('notas')->toString() ?: null,
        );
    }
}
