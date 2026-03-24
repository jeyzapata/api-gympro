<?php

declare(strict_types=1);

namespace App\DTOs\MetodoPago;

final readonly class UpdateMetodoPagoPayload
{
    public function __construct(
        public ?string $nombre = null,
        public ?string $tipo = null,
        public ?bool   $requiereReferencia = null,
        public ?bool   $activo = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'nombre'              => $this->nombre,
            'tipo'                => $this->tipo,
            'requiere_referencia' => $this->requiereReferencia,
            'activo'              => $this->activo,
        ], fn ($value) => $value !== null);
    }
}
