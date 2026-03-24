<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\FacturaTenant;
use App\Repositories\Contracts\FacturaTenantRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class FacturaTenantRepository implements FacturaTenantRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator
    {
        return FacturaTenant::with(['tenant', 'planPlataforma'])
            ->latest()
            ->paginate($perPage);
    }

    public function findOrFail(int $id): FacturaTenant
    {
        return FacturaTenant::with(['tenant', 'planPlataforma'])
            ->findOrFail($id);
    }

    public function create(array $data): FacturaTenant
    {
        return FacturaTenant::create($data);
    }

    public function update(int $id, array $data): FacturaTenant
    {
        $factura = FacturaTenant::findOrFail($id);
        $factura->update($data);

        return $factura->fresh(['tenant', 'planPlataforma']);
    }

    public function delete(int $id): void
    {
        FacturaTenant::findOrFail($id)->delete();
    }
}
