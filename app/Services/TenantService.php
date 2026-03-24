<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Tenant;
use App\Repositories\Contracts\TenantRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class TenantService
{
    public function __construct(
        private readonly TenantRepositoryInterface $tenantRepository
    ) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->tenantRepository->all($perPage);
    }

    public function findOrFail(int $id): Tenant
    {
        return $this->tenantRepository->findOrFail($id);
    }
}
