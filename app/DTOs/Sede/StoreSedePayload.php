<?php

declare(strict_types=1);

namespace App\DTOs\Sede;

final readonly class StoreSedePayload
{
    public function __construct(
        public string  $nombre,
        public string  $direccion,
        public string  $ciudad,
        public string  $provincia,
        public ?string $telefono = null,
        public ?string $email = null,
        public ?string $horarioApertura = null,
        public ?string $horarioCierre = null,
        public bool    $activa = true,
    ) {}

    public function toArray(): array
    {
        return [
            'nombre'           => $this->nombre,
            'direccion'        => $this->direccion,
            'ciudad'           => $this->ciudad,
            'provincia'        => $this->provincia,
            'telefono'         => $this->telefono,
            'email'            => $this->email,
            'horario_apertura' => $this->horarioApertura,
            'horario_cierre'   => $this->horarioCierre,
            'activa'           => $this->activa,
        ];
    }
}
