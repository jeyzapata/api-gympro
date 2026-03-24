<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\Auth\LoginPayload;
use App\Repositories\Contracts\AdminUserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

final class AdminAuthService
{
    public function __construct(
        private readonly AdminUserRepositoryInterface $adminUserRepository
    ) {}

    public function login(LoginPayload $payload): ?array
    {
        $user = $this->adminUserRepository->findByEmail($payload->email);

        if (! $user || ! Hash::check($payload->password, $user->password)) {
            return null;
        }

        $user->update(['ultimo_login' => now()]);

        return [
            'token' => $user->createToken('admin-token')->plainTextToken,
            'user'  => $user,
        ];
    }
}
