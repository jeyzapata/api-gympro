<?php

declare(strict_types=1);

namespace App\Http\Requests\Clase;

use App\DTOs\Clase\StoreClasePayload;
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
            'sede_id'               => ['required', 'integer', 'exists:sedes,id'],
            'tipo_clase_id'         => ['required', 'integer', 'exists:tipo_clases,id'],
            'empleado_id'           => ['required', 'integer', 'exists:empleados,id'],
            'nombre'                => ['required', 'string', 'max:150'],
            'descripcion'           => ['nullable', 'string'],
            'dia_semana'            => ['nullable', 'integer', 'in:1,2,3,4,5,6,7'],
            'hora_inicio'           => ['required', 'date_format:H:i'],
            'hora_fin'              => ['required', 'date_format:H:i', 'after:hora_inicio'],
            'capacidad_maxima'      => ['required', 'integer', 'min:1'],
            'es_recurrente'         => ['sometimes', 'boolean'],
            'fecha_inicio_vigencia' => ['nullable', 'date'],
            'fecha_fin_vigencia'    => ['nullable', 'date', 'after_or_equal:fecha_inicio_vigencia'],
            'activa'                => ['sometimes', 'boolean'],
        ];
    }

    public function payload(): StoreClasePayload
    {
        return new StoreClasePayload(
            sedeId:              $this->integer('sede_id'),
            tipoClaseId:         $this->integer('tipo_clase_id'),
            empleadoId:          $this->integer('empleado_id'),
            nombre:              $this->string('nombre')->toString(),
            horaInicio:          $this->string('hora_inicio')->toString(),
            horaFin:             $this->string('hora_fin')->toString(),
            capacidadMaxima:     $this->integer('capacidad_maxima'),
            descripcion:         $this->string('descripcion')->toString() ?: null,
            diaSemana:           $this->has('dia_semana') ? $this->integer('dia_semana') : null,
            esRecurrente:        $this->boolean('es_recurrente', true),
            fechaInicioVigencia: $this->string('fecha_inicio_vigencia')->toString() ?: null,
            fechaFinVigencia:    $this->string('fecha_fin_vigencia')->toString() ?: null,
            activa:              $this->boolean('activa', true),
        );
    }
}
