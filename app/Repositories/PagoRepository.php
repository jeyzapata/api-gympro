<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Pago;
use App\Repositories\Contracts\PagoRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class PagoRepository implements PagoRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator
    {
        return Pago::with(['socio', 'sede', 'empleado', 'metodoPago', 'membresia', 'promocion', 'pagoItems'])
            ->latest()
            ->paginate($perPage);
    }

    public function findOrFail(int $id): Pago
    {
        return Pago::with(['socio', 'sede', 'empleado', 'metodoPago', 'membresia', 'promocion', 'pagoItems'])->findOrFail($id);
    }

    public function create(array $data): Pago
    {
        return Pago::create($data);
    }

    public function update(int $id, array $data): Pago
    {
        $pago = Pago::findOrFail($id);
        $pago->update($data);

        return $pago->fresh(['socio', 'sede', 'empleado', 'metodoPago', 'membresia', 'promocion', 'pagoItems']);
    }

    public function delete(int $id): void
    {
        Pago::findOrFail($id)->delete();
    }
}
