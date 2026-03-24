<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Promocion;
use App\Repositories\Contracts\PromocionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class PromocionRepository implements PromocionRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator
    {
        return Promocion::with(['plan', 'sede'])
            ->latest()
            ->paginate($perPage);
    }

    public function findOrFail(int $id): Promocion
    {
        return Promocion::with(['plan', 'sede'])->findOrFail($id);
    }

    public function create(array $data): Promocion
    {
        return Promocion::create($data);
    }

    public function update(int $id, array $data): Promocion
    {
        $promocion = Promocion::findOrFail($id);
        $promocion->update($data);

        return $promocion->fresh(['plan', 'sede']);
    }

    public function delete(int $id): void
    {
        Promocion::findOrFail($id)->delete();
    }
}
