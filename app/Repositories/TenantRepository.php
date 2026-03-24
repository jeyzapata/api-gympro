<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Tenant;
use App\Repositories\Contracts\TenantRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class TenantRepository implements TenantRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator
    {
        return Tenant::where('suscripcion_activa', true)
            ->latest()
            ->paginate($perPage);
    }

    public function findOrFail(int $id): Tenant
    {
        return Tenant::findOrFail($id);
    }
}
