<?php

declare(strict_types=1);

namespace App\DTOs\Sede;

final readonly class UpdateSedePayload
{
    public function __construct(
        public ?string $nombre = null,
        public ?string $direccion = null,
        public ?string $ciudad = null,
        public ?string $provincia = null,
        public ?string $telefono = null,
        public ?string $email = null,
        public ?string $horarioApertura = null,
        public ?string $horarioCierre = null,
        public ?bool   $activa = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'nombre'           => $this->nombre,
            'direccion'        => $this->direccion,
            'ciudad'           => $this->ciudad,
            'provincia'        => $this->provincia,
            'telefono'         => $this->telefono,
            'email'            => $this->email,
            'horario_apertura' => $this->horarioApertura,
            'horario_cierre'   => $this->horarioCierre,
            'activa'           => $this->activa,
        ], fn ($value) => $value !== null);
    }
}
