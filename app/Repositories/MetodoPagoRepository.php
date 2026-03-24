<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\MetodoPago;
use App\Repositories\Contracts\MetodoPagoRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class MetodoPagoRepository implements MetodoPagoRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator
    {
        return MetodoPago::orderBy('nombre')->paginate($perPage);
    }

    public function findOrFail(int $id): MetodoPago
    {
        return MetodoPago::findOrFail($id);
    }

    public function create(array $data): MetodoPago
    {
        return MetodoPago::create($data);
    }

    public function update(int $id, array $data): MetodoPago
    {
        $metodoPago = $this->findOrFail($id);
        $metodoPago->update($data);
        return $metodoPago->fresh();
    }

    public function delete(int $id): void
    {
        MetodoPago::findOrFail($id)->delete();
    }
}
