<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\AdminUser;

interface AdminUserRepositoryInterface
{
    public function findByEmail(string $email): ?AdminUser;
}
