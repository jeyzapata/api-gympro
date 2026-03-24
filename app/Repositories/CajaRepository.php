<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Caja;
use App\Repositories\Contracts\CajaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class CajaRepository implements CajaRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator
    {
        return Caja::with(['sede', 'empleado', 'movimientosCaja'])
            ->latest()
            ->paginate($perPage);
    }

    public function findOrFail(int $id): Caja
    {
        return Caja::with(['sede', 'empleado', 'movimientosCaja'])->findOrFail($id);
    }

    public function create(array $data): Caja
    {
        return Caja::create($data);
    }

    public function update(int $id, array $data): Caja
    {
        $caja = Caja::findOrFail($id);
        $caja->update($data);

        return $caja->fresh(['sede', 'empleado', 'movimientosCaja']);
    }

    public function delete(int $id): void
    {
        Caja::findOrFail($id)->delete();
    }
}
