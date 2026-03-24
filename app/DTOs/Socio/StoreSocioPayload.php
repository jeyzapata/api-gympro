<?php

declare(strict_types=1);

namespace App\DTOs\Socio;

final readonly class StoreSocioPayload
{
    public function __construct(
        public int     $sedeId,
        public string  $nombre,
        public string  $apellido,
        public string  $dni,
        public string  $email,
        public string  $numeroSocio,
        public ?string $telefono = null,
        public ?string $fechaNacimiento = null,
        public ?string $sexo = null,
        public ?string $direccion = null,
        public ?string $foto = null,
        public ?int    $referidoPorId = null,
        public bool    $activo = true,
    ) {}

    public function toArray(): array
    {
        return [
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
        ];
    }
}
