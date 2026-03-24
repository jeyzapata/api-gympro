<?php

declare(strict_types=1);

namespace App\DTOs\Empleado;

final readonly class StoreEmpleadoPayload
{
    public function __construct(
        public int     $sedeId,
        public int     $rolId,
        public string  $nombre,
        public string  $apellido,
        public string  $dni,
        public string  $email,
        public string  $fechaIngreso,
        public ?string $telefono = null,
        public ?string $fechaNacimiento = null,
        public ?array  $especialidades = null,
        public bool    $activo = true,
        public ?string $foto = null,
    ) {}

    public function toArray(): array
    {
        return [
            'sede_id'          => $this->sedeId,
            'rol_id'           => $this->rolId,
            'nombre'           => $this->nombre,
            'apellido'         => $this->apellido,
            'dni'              => $this->dni,
            'email'            => $this->email,
            'fecha_ingreso'    => $this->fechaIngreso,
            'telefono'         => $this->telefono,
            'fecha_nacimiento' => $this->fechaNacimiento,
            'especialidades'   => $this->especialidades,
            'activo'           => $this->activo,
            'foto'             => $this->foto,
        ];
    }
}
