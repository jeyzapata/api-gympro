<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\Auth\LoginPayload;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

final class AuthService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function login(LoginPayload $payload): ?array
    {
        $user = $this->userRepository->findByEmail($payload->email);

        if (! $user || ! Hash::check($payload->password, $user->password)) {
            return null;
        }

        return [
            'token' => $user->createToken('api-token')->plainTextToken,
            'user'  => $user,
        ];
    }
}
