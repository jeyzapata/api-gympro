<?php

declare(strict_types=1);

namespace App\DTOs\User;

final readonly class UpdateUserPayload
{
    public function __construct(
        public ?string $email = null,
        public ?string $password = null,
        public ?string $userableType = null,
        public ?int    $userableId = null,
        public ?string $pushToken = null,
        public ?bool   $activo = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'email'          => $this->email,
            'password'       => $this->password,
            'userable_type'  => $this->userableType,
            'userable_id'    => $this->userableId,
            'push_token'     => $this->pushToken,
            'activo'         => $this->activo,
        ], fn ($value) => $value !== null);
    }
}
