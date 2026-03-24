<?php

declare(strict_types=1);

namespace App\Http\Requests\MedicionSocio;

use App\DTOs\MedicionSocio\UpdateMedicionSocioPayload;
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
            'socio_id'         => ['sometimes', 'integer', 'exists:socios,id'],
            'empleado_id'      => ['sometimes', 'nullable', 'integer', 'exists:empleados,id'],
            'fecha'            => ['sometimes', 'date'],
            'peso_kg'          => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'altura_cm'        => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'imc'              => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'porcentaje_grasa' => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'masa_muscular_kg' => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'cintura_cm'       => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'cadera_cm'        => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'pecho_cm'         => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'notas'            => ['sometimes', 'nullable', 'string'],
        ];
    }

    public function payload(): UpdateMedicionSocioPayload
    {
        return new UpdateMedicionSocioPayload(
            socioId:        $this->has('socio_id') ? $this->integer('socio_id') : null,
            empleadoId:     $this->has('empleado_id') ? $this->integer('empleado_id') ?: null : null,
            fecha:          $this->has('fecha') ? $this->string('fecha')->toString() : null,
            pesoKg:         $this->has('peso_kg') ? ($this->input('peso_kg') !== null ? (float) $this->input('peso_kg') : null) : null,
            alturaCm:       $this->has('altura_cm') ? ($this->input('altura_cm') !== null ? (float) $this->input('altura_cm') : null) : null,
            imc:            $this->has('imc') ? ($this->input('imc') !== null ? (float) $this->input('imc') : null) : null,
            porcentajeGrasa: $this->has('porcentaje_grasa') ? ($this->input('porcentaje_grasa') !== null ? (float) $this->input('porcentaje_grasa') : null) : null,
            masaMuscularKg: $this->has('masa_muscular_kg') ? ($this->input('masa_muscular_kg') !== null ? (float) $this->input('masa_muscular_kg') : null) : null,
            cinturaCm:      $this->has('cintura_cm') ? ($this->input('cintura_cm') !== null ? (float) $this->input('cintura_cm') : null) : null,
            caderaCm:       $this->has('cadera_cm') ? ($this->input('cadera_cm') !== null ? (float) $this->input('cadera_cm') : null) : null,
            pechoCm:        $this->has('pecho_cm') ? ($this->input('pecho_cm') !== null ? (float) $this->input('pecho_cm') : null) : null,
            notas:          $this->has('notas') ? $this->string('notas')->toString() ?: null : null,
        );
    }
}
