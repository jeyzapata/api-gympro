<?php

declare(strict_types=1);

namespace App\Http\Requests\Clase;

use App\DTOs\Clase\UpdateClasePayload;
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
            'sede_id'               => ['sometimes', 'integer', 'exists:sedes,id'],
            'tipo_clase_id'         => ['sometimes', 'integer', 'exists:tipo_clases,id'],
            'empleado_id'           => ['sometimes', 'integer', 'exists:empleados,id'],
            'nombre'                => ['sometimes', 'string', 'max:150'],
            'descripcion'           => ['nullable', 'string'],
            'dia_semana'            => ['nullable', 'integer', 'in:1,2,3,4,5,6,7'],
            'hora_inicio'           => ['sometimes', 'date_format:H:i'],
            'hora_fin'              => ['sometimes', 'date_format:H:i', 'after:hora_inicio'],
            'capacidad_maxima'      => ['sometimes', 'integer', 'min:1'],
            'es_recurrente'         => ['sometimes', 'boolean'],
            'fecha_inicio_vigencia' => ['nullable', 'date'],
            'fecha_fin_vigencia'    => ['nullable', 'date', 'after_or_equal:fecha_inicio_vigencia'],
            'activa'                => ['sometimes', 'boolean'],
        ];
    }

    public function payload(): UpdateClasePayload
    {
        $validated = $this->validated();

        return new UpdateClasePayload(
            sedeId:              isset($validated['sede_id']) ? $this->integer('sede_id') : null,
            tipoClaseId:         isset($validated['tipo_clase_id']) ? $this->integer('tipo_clase_id') : null,
            empleadoId:          isset($validated['empleado_id']) ? $this->integer('empleado_id') : null,
            nombre:              isset($validated['nombre']) ? $this->string('nombre')->toString() : null,
            descripcion:         array_key_exists('descripcion', $validated) ? ($this->string('descripcion')->toString() ?: null) : null,
            diaSemana:           array_key_exists('dia_semana', $validated) ? (isset($validated['dia_semana']) ? $this->integer('dia_semana') : null) : null,
            horaInicio:          isset($validated['hora_inicio']) ? $this->string('hora_inicio')->toString() : null,
            horaFin:             isset($validated['hora_fin']) ? $this->string('hora_fin')->toString() : null,
            capacidadMaxima:     isset($validated['capacidad_maxima']) ? $this->integer('capacidad_maxima') : null,
            esRecurrente:        isset($validated['es_recurrente']) ? $this->boolean('es_recurrente') : null,
            fechaInicioVigencia: array_key_exists('fecha_inicio_vigencia', $validated) ? ($this->string('fecha_inicio_vigencia')->toString() ?: null) : null,
            fechaFinVigencia:    array_key_exists('fecha_fin_vigencia', $validated) ? ($this->string('fecha_fin_vigencia')->toString() ?: null) : null,
            activa:              isset($validated['activa']) ? $this->boolean('activa') : null,
        );
    }
}
