<?php

declare(strict_types=1);

namespace App\Http\Requests\Socio;

use App\DTOs\Socio\StoreSocioPayload;
use App\Enums\Sexo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sede_id'          => ['required', 'integer', 'exists:sedes,id'],
            'nombre'           => ['required', 'string', 'min:2', 'max:100'],
            'apellido'         => ['required', 'string', 'min:2', 'max:100'],
            'dni'              => ['required', 'string', 'max:20', 'unique:socios,dni'],
            'email'            => ['required', 'email:rfc,dns', 'max:150', 'unique:socios,email'],
            'telefono'         => ['nullable', 'string', 'max:30'],
            'fecha_nacimiento' => ['nullable', 'date', 'before:today'],
            'sexo'             => ['nullable', 'string', Rule::enum(Sexo::class)],
            'direccion'        => ['nullable', 'string', 'max:255'],
            'foto'             => ['nullable', 'string', 'max:255'],
            'numero_socio'     => ['required', 'string', 'max:30', 'unique:socios,numero_socio'],
            'referido_por_id'  => ['nullable', 'integer', 'exists:socios,id'],
            'activo'           => ['sometimes', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nombre'   => $this->has('nombre') ? trim($this->input('nombre')) : null,
            'apellido' => $this->has('apellido') ? trim($this->input('apellido')) : null,
            'email'    => $this->has('email') ? strtolower(trim($this->input('email'))) : null,
        ]);
    }

    public function payload(): StoreSocioPayload
    {
        return new StoreSocioPayload(
            sedeId:          $this->integer('sede_id'),
            nombre:          $this->string('nombre')->toString(),
            apellido:        $this->string('apellido')->toString(),
            dni:             $this->string('dni')->toString(),
            email:           $this->string('email')->toString(),
            numeroSocio:     $this->string('numero_socio')->toString(),
            telefono:        $this->string('telefono')->toString() ?: null,
            fechaNacimiento: $this->string('fecha_nacimiento')->toString() ?: null,
            sexo:            $this->string('sexo')->toString() ?: null,
            direccion:       $this->string('direccion')->toString() ?: null,
            foto:            $this->string('foto')->toString() ?: null,
            referidoPorId:   $this->has('referido_por_id') ? $this->integer('referido_por_id') ?: null : null,
            activo:          $this->boolean('activo', true),
        );
    }
}
