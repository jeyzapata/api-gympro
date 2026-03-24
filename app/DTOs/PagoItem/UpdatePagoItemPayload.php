<?php

declare(strict_types=1);

namespace App\DTOs\PagoItem;

final readonly class UpdatePagoItemPayload
{
    public function __construct(
        public ?int    $pagoId = null,
        public ?string $descripcion = null,
        public ?int    $cantidad = null,
        public ?string $precioUnitario = null,
        public ?string $subtotal = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'pago_id'         => $this->pagoId,
            'descripcion'     => $this->descripcion,
            'cantidad'        => $this->cantidad,
            'precio_unitario' => $this->precioUnitario,
            'subtotal'        => $this->subtotal,
        ], fn ($value) => $value !== null);
    }
}
