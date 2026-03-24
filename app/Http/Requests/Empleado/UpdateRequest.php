<?php

declare(strict_types=1);

namespace App\Http\Requests\Empleado;

use App\DTOs\Empleado\UpdateEmpleadoPayload;
use Illuminate\Foundation\Http\FormRequest;

final class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $empleadoId = $this->route('empleado');
        return [
            'sede_id'          => ['sometimes', 'integer', 'exists:sedes,id'],
            'rol_id'           => ['sometimes', 'integer', 'exists:rols,id'],
            'nombre'           => ['sometimes', 'string', 'min:2', 'max:100'],
            'apellido'         => ['sometimes', 'string', 'min:2', 'max:100'],
            'dni'              => ['sometimes', 'string', 'max:20', "unique:empleados,dni,{$empleadoId}"],
            'email'            => ['sometimes', 'email:rfc,dns', 'max:150', "unique:empleados,email,{$empleadoId}"],
            'telefono'         => ['nullable', 'string', 'max:30'],
            'fecha_nacimiento' => ['nullable', 'date', 'before:today'],
            'fecha_ingreso'    => ['sometimes', 'date'],
            'especialidades'   => ['nullable', 'array'],
            'especialidades.*' => ['string', 'max:100'],
            'activo'           => ['sometimes', 'boolean'],
            'foto'             => ['nullable', 'string', 'max:255'],
        ];
    }

    public function payload(): UpdateEmpleadoPayload
    {
        return new UpdateEmpleadoPayload(
            sedeId:          $this->has('sede_id') ? $this->integer('sede_id') : null,
            rolId:           $this->has('rol_id') ? $this->integer('rol_id') : null,
            nombre:          $this->has('nombre') ? $this->string('nombre')->toString() : null,
            apellido:        $this->has('apellido') ? $this->string('apellido')->toString() : null,
            dni:             $this->has('dni') ? $this->string('dni')->toString() : null,
            email:           $this->has('email') ? $this->string('email')->toString() : null,
            telefono:        $this->has('telefono') ? $this->string('telefono')->toString() ?: null : null,
            fechaNacimiento: $this->has('fecha_nacimiento') ? $this->string('fecha_nacimiento')->toString() ?: null : null,
            fechaIngreso:    $this->has('fecha_ingreso') ? $this->string('fecha_ingreso')->toString() : null,
            especialidades:  $this->has('especialidades') ? $this->input('especialidades') : null,
            activo:          $this->has('activo') ? $this->boolean('activo') : null,
            foto:            $this->has('foto') ? $this->string('foto')->toString() ?: null : null,
        );
    }
}
