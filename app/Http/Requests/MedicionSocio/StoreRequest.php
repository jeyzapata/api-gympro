<?php

declare(strict_types=1);

namespace App\Http\Requests\MedicionSocio;

use App\DTOs\MedicionSocio\StoreMedicionSocioPayload;
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
            'socio_id'         => ['required', 'integer', 'exists:socios,id'],
            'empleado_id'      => ['nullable', 'integer', 'exists:empleados,id'],
            'fecha'            => ['required', 'date'],
            'peso_kg'          => ['nullable', 'numeric', 'min:0'],
            'altura_cm'        => ['nullable', 'numeric', 'min:0'],
            'imc'              => ['nullable', 'numeric', 'min:0'],
            'porcentaje_grasa' => ['nullable', 'numeric', 'min:0'],
            'masa_muscular_kg' => ['nullable', 'numeric', 'min:0'],
            'cintura_cm'       => ['nullable', 'numeric', 'min:0'],
            'cadera_cm'        => ['nullable', 'numeric', 'min:0'],
            'pecho_cm'         => ['nullable', 'numeric', 'min:0'],
            'notas'            => ['nullable', 'string'],
        ];
    }

    public function payload(): StoreMedicionSocioPayload
    {
        return new StoreMedicionSocioPayload(
            socioId:        $this->integer('socio_id'),
            fecha:          $this->string('fecha')->toString(),
            empleadoId:     $this->has('empleado_id') ? $this->integer('empleado_id') ?: null : null,
            pesoKg:         $this->has('peso_kg') ? (float) $this->input('peso_kg') : null,
            alturaCm:       $this->has('altura_cm') ? (float) $this->input('altura_cm') : null,
            imc:            $this->has('imc') ? (float) $this->input('imc') : null,
            porcentajeGrasa: $this->has('porcentaje_grasa') ? (float) $this->input('porcentaje_grasa') : null,
            masaMuscularKg: $this->has('masa_muscular_kg') ? (float) $this->input('masa_muscular_kg') : null,
            cinturaCm:      $this->has('cintura_cm') ? (float) $this->input('cintura_cm') : null,
            caderaCm:       $this->has('cadera_cm') ? (float) $this->input('cadera_cm') : null,
            pechoCm:        $this->has('pecho_cm') ? (float) $this->input('pecho_cm') : null,
            notas:          $this->has('notas') ? $this->string('notas')->toString() ?: null : null,
        );
    }
}
