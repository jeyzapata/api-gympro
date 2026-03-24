<?php

declare(strict_types=1);

namespace App\Http\Requests\Socio;

use App\DTOs\Socio\UpdateSocioPayload;
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
        $socioId = $this->route('socio');

        return [
            'sede_id'          => ['sometimes', 'integer', 'exists:sedes,id'],
            'nombre'           => ['sometimes', 'string', 'min:2', 'max:100'],
            'apellido'         => ['sometimes', 'string', 'min:2', 'max:100'],
            'dni'              => ['sometimes', 'string', 'max:20', Rule::unique('socios', 'dni')->ignore($socioId)],
            'email'            => ['sometimes', 'email:rfc,dns', 'max:150', Rule::unique('socios', 'email')->ignore($socioId)],
            'telefono'         => ['nullable', 'string', 'max:30'],
            'fecha_nacimiento' => ['nullable', 'date', 'before:today'],
            'sexo'             => ['nullable', 'string', 'in:masculino,femenino,otro'],
            'direccion'        => ['nullable', 'string', 'max:255'],
            'foto'             => ['nullable', 'string', 'max:255'],
            'numero_socio'     => ['sometimes', 'string', 'max:30', Rule::unique('socios', 'numero_socio')->ignore($socioId)],
            'referido_por_id'  => ['nullable', 'integer', 'exists:socios,id'],
            'activo'           => ['sometimes', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $merge = [];

        if ($this->has('nombre')) {
            $merge['nombre'] = trim($this->input('nombre'));
        }
        if ($this->has('apellido')) {
            $merge['apellido'] = trim($this->input('apellido'));
        }
        if ($this->has('email')) {
            $merge['email'] = strtolower(trim($this->input('email')));
        }

        if ($merge) {
            $this->merge($merge);
        }
    }

    public function payload(): UpdateSocioPayload
    {
        return new UpdateSocioPayload(
            sedeId:          $this->has('sede_id') ? $this->integer('sede_id') : null,
            nombre:          $this->has('nombre') ? $this->string('nombre')->toString() : null,
            apellido:        $this->has('apellido') ? $this->string('apellido')->toString() : null,
            dni:             $this->has('dni') ? $this->string('dni')->toString() : null,
            email:           $this->has('email') ? $this->string('email')->toString() : null,
            numeroSocio:     $this->has('numero_socio') ? $this->string('numero_socio')->toString() : null,
            telefono:        $this->has('telefono') ? $this->string('telefono')->toString() ?: null : null,
            fechaNacimiento: $this->has('fecha_nacimiento') ? $this->string('fecha_nacimiento')->toString() ?: null : null,
            sexo:            $this->has('sexo') ? $this->string('sexo')->toString() ?: null : null,
            direccion:       $this->has('direccion') ? $this->string('direccion')->toString() ?: null : null,
            foto:            $this->has('foto') ? $this->string('foto')->toString() ?: null : null,
            referidoPorId:   $this->has('referido_por_id') ? $this->integer('referido_por_id') ?: null : null,
            activo:          $this->has('activo') ? $this->boolean('activo') : null,
        );
    }
}
