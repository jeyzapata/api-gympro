<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\PlanPrecio;
use App\Repositories\Contracts\PlanPrecioRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class PlanPrecioRepository implements PlanPrecioRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator
    {
        return PlanPrecio::with(['plan', 'sede', 'empleado'])
            ->latest()
            ->paginate($perPage);
    }

    public function findOrFail(int $id): PlanPrecio
    {
        return PlanPrecio::with(['plan', 'sede', 'empleado'])->findOrFail($id);
    }

    public function create(array $data): PlanPrecio
    {
        return PlanPrecio::create($data);
    }

    public function update(int $id, array $data): PlanPrecio
    {
        $planPrecio = $this->findOrFail($id);
        $planPrecio->update($data);

        return $planPrecio->fresh(['plan', 'sede', 'empleado']);
    }

    public function delete(int $id): void
    {
        PlanPrecio::findOrFail($id)->delete();
    }
}
