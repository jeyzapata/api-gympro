<?php

declare(strict_types=1);

namespace App\DTOs\PagoItem;

final readonly class StorePagoItemPayload
{
    public function __construct(
        public int    $pagoId,
        public string $descripcion,
        public string $precioUnitario,
        public string $subtotal,
        public int    $cantidad = 1,
    ) {}

    public function toArray(): array
    {
        return [
            'pago_id'         => $this->pagoId,
            'descripcion'     => $this->descripcion,
            'cantidad'        => $this->cantidad,
            'precio_unitario' => $this->precioUnitario,
            'subtotal'        => $this->subtotal,
        ];
    }
}
