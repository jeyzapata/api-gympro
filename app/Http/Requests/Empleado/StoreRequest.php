<?php

declare(strict_types=1);

namespace App\Http\Requests\Empleado;

use App\DTOs\Empleado\StoreEmpleadoPayload;
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
            'sede_id'          => ['required', 'integer', 'exists:sedes,id'],
            'rol_id'           => ['required', 'integer', 'exists:rols,id'],
            'nombre'           => ['required', 'string', 'min:2', 'max:100'],
            'apellido'         => ['required', 'string', 'min:2', 'max:100'],
            'dni'              => ['required', 'string', 'max:20', 'unique:empleados,dni'],
            'email'            => ['required', 'email:rfc,dns', 'max:150', 'unique:empleados,email'],
            'telefono'         => ['nullable', 'string', 'max:30'],
            'fecha_nacimiento' => ['nullable', 'date', 'before:today'],
            'fecha_ingreso'    => ['required', 'date'],
            'especialidades'   => ['nullable', 'array'],
            'especialidades.*' => ['string', 'max:100'],
            'activo'           => ['sometimes', 'boolean'],
            'foto'             => ['nullable', 'string', 'max:255'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'email'  => strtolower(trim($this->email ?? '')),
            'nombre' => trim($this->nombre ?? ''),
            'apellido' => trim($this->apellido ?? ''),
        ]);
    }

    public function payload(): StoreEmpleadoPayload
    {
        return new StoreEmpleadoPayload(
            sedeId:          $this->integer('sede_id'),
            rolId:           $this->integer('rol_id'),
            nombre:          $this->string('nombre')->toString(),
            apellido:        $this->string('apellido')->toString(),
            dni:             $this->string('dni')->toString(),
            email:           $this->string('email')->toString(),
            fechaIngreso:    $this->string('fecha_ingreso')->toString(),
            telefono:        $this->string('telefono')->toString() ?: null,
            fechaNacimiento: $this->string('fecha_nacimiento')->toString() ?: null,
            especialidades:  $this->input('especialidades'),
            activo:          $this->boolean('activo', true),
            foto:            $this->string('foto')->toString() ?: null,
        );
    }
}
