<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\AdminUser;
use App\Repositories\Contracts\AdminUserRepositoryInterface;

final class AdminUserRepository implements AdminUserRepositoryInterface
{
    public function findByEmail(string $email): ?AdminUser
    {
        return AdminUser::where('email', $email)->first();
    }
}
