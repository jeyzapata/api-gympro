<?php

declare(strict_types=1);

namespace App\DTOs\MetodoPago;

final readonly class StoreMetodoPagoPayload
{
    public function __construct(
        public string $nombre,
        public string $tipo,
        public bool   $requiereReferencia = false,
        public bool   $activo = true,
    ) {}

    public function toArray(): array
    {
        return [
            'nombre'              => $this->nombre,
            'tipo'                => $this->tipo,
            'requiere_referencia' => $this->requiereReferencia,
            'activo'              => $this->activo,
        ];
    }
}
