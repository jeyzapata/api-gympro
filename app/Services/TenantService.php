<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\Tenant\StoreTenantPayload;
use App\DTOs\Tenant\UpdateTenantPayload;
use App\Models\Tenant;
use App\Repositories\Contracts\TenantRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class TenantService
{
    public function __construct(
        private readonly TenantRepositoryInterface $tenantRepository
    ) {}

    public function getAll(int $perPage = 15, bool $activeOnly = false): LengthAwarePaginator
    {
        return $this->tenantRepository->all($perPage, $activeOnly);
    }

    public function findOrFail(int $id): Tenant
    {
        return $this->tenantRepository->findOrFail($id);
    }

    public function create(StoreTenantPayload $payload): Tenant
    {
        return DB::transaction(
            fn () => $this->tenantRepository->create($payload->toArray())
        );
    }

    public function update(int $id, UpdateTenantPayload $payload): Tenant
    {
        return DB::transaction(
            fn () => $this->tenantRepository->update($id, $payload->toArray())
        );
    }

    public function delete(int $id): void
    {
        DB::transaction(fn () => $this->tenantRepository->delete($id));
    }
}
