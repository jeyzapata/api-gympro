<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Tenant;
use App\Repositories\Contracts\TenantRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class TenantRepository implements TenantRepositoryInterface
{
    public function all(int $perPage = 15, bool $activeOnly = false): LengthAwarePaginator
    {
        return Tenant::when($activeOnly, fn ($q) => $q->where('suscripcion_activa', true))
            ->latest()
            ->paginate($perPage);
    }

    public function findOrFail(int $id): Tenant
    {
        return Tenant::findOrFail($id);
    }

    public function create(array $data): Tenant
    {
        return Tenant::create($data);
    }

    public function update(int $id, array $data): Tenant
    {
        $tenant = Tenant::findOrFail($id);
        $tenant->update($data);

        return $tenant->fresh();
    }

    public function delete(int $id): void
    {
        Tenant::findOrFail($id)->delete();
    }
}
