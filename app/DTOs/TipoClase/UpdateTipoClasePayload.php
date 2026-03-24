<?php

declare(strict_types=1);

namespace App\DTOs\TipoClase;

final readonly class UpdateTipoClasePayload
{
    public function __construct(
        public ?string $nombre = null,
        public ?string $descripcion = null,
        public ?int    $duracionMinutos = null,
        public ?int    $capacidadMaxima = null,
        public ?string $color = null,
        public ?bool   $activo = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'nombre'           => $this->nombre,
            'descripcion'      => $this->descripcion,
            'duracion_minutos' => $this->duracionMinutos,
            'capacidad_maxima' => $this->capacidadMaxima,
            'color'            => $this->color,
            'activo'           => $this->activo,
        ], fn ($value) => $value !== null);
    }
}
