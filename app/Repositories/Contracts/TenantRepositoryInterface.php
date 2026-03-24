<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Tenant;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TenantRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator;
    public function findOrFail(int $id): Tenant;
}
