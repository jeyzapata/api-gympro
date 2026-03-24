<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\MovimientoCaja;
use App\Repositories\Contracts\MovimientoCajaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class MovimientoCajaRepository implements MovimientoCajaRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator
    {
        return MovimientoCaja::with(['caja', 'pago', 'empleado'])->orderByDesc('created_at')->paginate($perPage);
    }

    public function findOrFail(int $id): MovimientoCaja
    {
        return MovimientoCaja::with(['caja', 'pago', 'empleado'])->findOrFail($id);
    }

    public function create(array $data): MovimientoCaja
    {
        return MovimientoCaja::create($data);
    }

    public function update(int $id, array $data): MovimientoCaja
    {
        $movimientoCaja = $this->findOrFail($id);
        $movimientoCaja->update($data);
        return $movimientoCaja->fresh(['caja', 'pago', 'empleado']);
    }

    public function delete(int $id): void
    {
        MovimientoCaja::findOrFail($id)->delete();
    }
}
