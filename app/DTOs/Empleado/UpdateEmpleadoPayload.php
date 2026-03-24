<?php

declare(strict_types=1);

namespace App\DTOs\Empleado;

final readonly class UpdateEmpleadoPayload
{
    public function __construct(
        public ?int    $sedeId = null,
        public ?int    $rolId = null,
        public ?string $nombre = null,
        public ?string $apellido = null,
        public ?string $dni = null,
        public ?string $email = null,
        public ?string $telefono = null,
        public ?string $fechaNacimiento = null,
        public ?string $fechaIngreso = null,
        public ?array  $especialidades = null,
        public ?bool   $activo = null,
        public ?string $foto = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'sede_id'          => $this->sedeId,
            'rol_id'           => $this->rolId,
            'nombre'           => $this->nombre,
            'apellido'         => $this->apellido,
            'dni'              => $this->dni,
            'email'            => $this->email,
            'telefono'         => $this->telefono,
            'fecha_nacimiento' => $this->fechaNacimiento,
            'fecha_ingreso'    => $this->fechaIngreso,
            'especialidades'   => $this->especialidades,
            'activo'           => $this->activo,
            'foto'             => $this->foto,
        ], fn ($value) => $value !== null);
    }
}
