<?php

declare(strict_types=1);

namespace App\DTOs\Socio;

final readonly class UpdateSocioPayload
{
    public function __construct(
        public ?int    $sedeId = null,
        public ?string $nombre = null,
        public ?string $apellido = null,
        public ?string $dni = null,
        public ?string $email = null,
        public ?string $numeroSocio = null,
        public ?string $telefono = null,
        public ?string $fechaNacimiento = null,
        public ?string $sexo = null,
        public ?string $direccion = null,
        public ?string $foto = null,
        public ?int    $referidoPorId = null,
        public ?bool   $activo = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'sede_id'          => $this->sedeId,
            'nombre'           => $this->nombre,
            'apellido'         => $this->apellido,
            'dni'              => $this->dni,
            'email'            => $this->email,
            'numero_socio'     => $this->numeroSocio,
            'telefono'         => $this->telefono,
            'fecha_nacimiento' => $this->fechaNacimiento,
            'sexo'             => $this->sexo,
            'direccion'        => $this->direccion,
            'foto'             => $this->foto,
            'referido_por_id'  => $this->referidoPorId,
            'activo'           => $this->activo,
        ], fn ($value) => $value !== null);
    }
}
