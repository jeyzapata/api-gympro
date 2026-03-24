<?php

declare(strict_types=1);

namespace App\Http\Requests\Sede;

use App\DTOs\Sede\UpdateSedePayload;
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
            'nombre'           => ['sometimes', 'string', 'min:2', 'max:120'],
            'direccion'        => ['sometimes', 'string', 'max:255'],
            'ciudad'           => ['sometimes', 'string', 'max:80'],
            'provincia'        => ['sometimes', 'string', 'max:80'],
            'telefono'         => ['nullable', 'string', 'max:30'],
            'email'            => ['nullable', 'email:rfc,dns', 'max:100'],
            'horario_apertura' => ['nullable', 'date_format:H:i'],
            'horario_cierre'   => ['nullable', 'date_format:H:i', 'after:horario_apertura'],
            'activa'           => ['sometimes', 'boolean'],
        ];
    }

    public function payload(): UpdateSedePayload
    {
        return new UpdateSedePayload(
            nombre:          $this->has('nombre') ? $this->string('nombre')->toString() : null,
            direccion:       $this->has('direccion') ? $this->string('direccion')->toString() : null,
            ciudad:          $this->has('ciudad') ? $this->string('ciudad')->toString() : null,
            provincia:       $this->has('provincia') ? $this->string('provincia')->toString() : null,
            telefono:        $this->has('telefono') ? $this->string('telefono')->toString() ?: null : null,
            email:           $this->has('email') ? $this->string('email')->toString() ?: null : null,
            horarioApertura: $this->has('horario_apertura') ? $this->string('horario_apertura')->toString() ?: null : null,
            horarioCierre:   $this->has('horario_cierre') ? $this->string('horario_cierre')->toString() ?: null : null,
            activa:          $this->has('activa') ? $this->boolean('activa') : null,
        );
    }
}
