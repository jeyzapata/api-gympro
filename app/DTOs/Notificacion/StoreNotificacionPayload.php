<?php

declare(strict_types=1);

namespace App\DTOs\Notificacion;

final readonly class StoreNotificacionPayload
{
    public function __construct(
        public int     $userId,
        public string  $titulo,
        public string  $cuerpo,
        public string  $tipo,
        public bool    $leida = false,
        public ?string $leidaAt = null,
        public ?array  $data = null,
    ) {}

    public function toArray(): array
    {
        return [
            'user_id'  => $this->userId,
            'titulo'   => $this->titulo,
            'cuerpo'   => $this->cuerpo,
            'tipo'     => $this->tipo,
            'leida'    => $this->leida,
            'leida_at' => $this->leidaAt,
            'data'     => $this->data,
        ];
    }
}
