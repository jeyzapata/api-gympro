<?php

declare(strict_types=1);

namespace App\DTOs\Notificacion;

final readonly class UpdateNotificacionPayload
{
    public function __construct(
        public ?int    $userId = null,
        public ?string $titulo = null,
        public ?string $cuerpo = null,
        public ?string $tipo = null,
        public ?bool   $leida = null,
        public ?string $leidaAt = null,
        public ?array  $data = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'user_id'  => $this->userId,
            'titulo'   => $this->titulo,
            'cuerpo'   => $this->cuerpo,
            'tipo'     => $this->tipo,
            'leida'    => $this->leida,
            'leida_at' => $this->leidaAt,
            'data'     => $this->data,
        ], fn ($value) => $value !== null);
    }
}
