<?php

declare(strict_types=1);

namespace App\DTOs\CategoriaEquipo;

final readonly class StoreCategoriaEquipoPayload
{
    public function __construct(
        public string  $nombre,
        public ?string $descripcion = null,
    ) {}

    public function toArray(): array
    {
        return [
            'nombre'      => $this->nombre,
            'descripcion' => $this->descripcion,
        ];
    }
}
