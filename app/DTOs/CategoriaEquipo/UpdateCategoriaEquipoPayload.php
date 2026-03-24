<?php

declare(strict_types=1);

namespace App\DTOs\CategoriaEquipo;

final readonly class UpdateCategoriaEquipoPayload
{
    public function __construct(
        public ?string $nombre = null,
        public ?string $descripcion = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'nombre'      => $this->nombre,
            'descripcion' => $this->descripcion,
        ], fn ($value) => $value !== null);
    }
}
