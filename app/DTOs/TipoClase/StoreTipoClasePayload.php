<?php

declare(strict_types=1);

namespace App\DTOs\TipoClase;

final readonly class StoreTipoClasePayload
{
    public function __construct(
        public string  $nombre,
        public int     $capacidadMaxima,
        public ?string $descripcion = null,
        public ?string $color = null,
        public int     $duracionMinutos = 60,
        public bool    $activo = true,
    ) {}

    public function toArray(): array
    {
        return [
            'nombre'           => $this->nombre,
            'descripcion'      => $this->descripcion,
            'duracion_minutos' => $this->duracionMinutos,
            'capacidad_maxima' => $this->capacidadMaxima,
            'color'            => $this->color,
            'activo'           => $this->activo,
        ];
    }
}
