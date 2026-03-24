<?php

declare(strict_types=1);

namespace App\Http\Requests\Sede;

use App\DTOs\Sede\StoreSedePayload;
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
            'nombre'           => ['required', 'string', 'min:2', 'max:120'],
            'direccion'        => ['required', 'string', 'max:255'],
            'ciudad'           => ['required', 'string', 'max:80'],
            'provincia'        => ['required', 'string', 'max:80'],
            'telefono'         => ['nullable', 'string', 'max:30'],
            'email'            => ['nullable', 'email:rfc,dns', 'max:100'],
            'horario_apertura' => ['nullable', 'date_format:H:i'],
            'horario_cierre'   => ['nullable', 'date_format:H:i', 'after:horario_apertura'],
            'activa'           => ['sometimes', 'boolean'],
        ];
    }

    public function payload(): StoreSedePayload
    {
        return new StoreSedePayload(
            nombre:          $this->string('nombre')->toString(),
            direccion:       $this->string('direccion')->toString(),
            ciudad:          $this->string('ciudad')->toString(),
            provincia:       $this->string('provincia')->toString(),
            telefono:        $this->string('telefono')->toString() ?: null,
            email:           $this->string('email')->toString() ?: null,
            horarioApertura: $this->string('horario_apertura')->toString() ?: null,
            horarioCierre:   $this->string('horario_cierre')->toString() ?: null,
            activa:          $this->boolean('activa', true),
        );
    }
}
