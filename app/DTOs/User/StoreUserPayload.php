<?php

declare(strict_types=1);

namespace App\DTOs\User;

final readonly class StoreUserPayload
{
    public function __construct(
        public string  $email,
        public string  $password,
        public string  $userableType,
        public int     $userableId,
        public ?string $pushToken = null,
        public bool    $activo = true,
    ) {}

    public function toArray(): array
    {
        return [
            'email'          => $this->email,
            'password'       => $this->password,
            'userable_type'  => $this->userableType,
            'userable_id'    => $this->userableId,
            'push_token'     => $this->pushToken,
            'activo'         => $this->activo,
        ];
    }
}
