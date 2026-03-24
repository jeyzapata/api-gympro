<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Tenant;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TenantRepositoryInterface
{
    public function all(int $perPage = 15, bool $activeOnly = false): LengthAwarePaginator;
    public function findOrFail(int $id): Tenant;
    public function create(array $data): Tenant;
    public function update(int $id, array $data): Tenant;
    public function delete(int $id): void;
}
