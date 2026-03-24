<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Deuda;
use App\Repositories\Contracts\DeudaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class DeudaRepository implements DeudaRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator
    {
        return Deuda::with(['socio', 'sede', 'membresia', 'pago'])
            ->latest()
            ->paginate($perPage);
    }

    public function findOrFail(int $id): Deuda
    {
        return Deuda::with(['socio', 'sede', 'membresia', 'pago'])->findOrFail($id);
    }

    public function create(array $data): Deuda
    {
        return Deuda::create($data);
    }

    public function update(int $id, array $data): Deuda
    {
        $deuda = Deuda::findOrFail($id);
        $deuda->update($data);

        return $deuda->fresh(['socio', 'sede', 'membresia', 'pago']);
    }

    public function delete(int $id): void
    {
        Deuda::findOrFail($id)->delete();
    }
}
