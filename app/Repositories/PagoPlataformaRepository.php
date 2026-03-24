<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\PagoPlataforma;
use App\Repositories\Contracts\PagoPlataformaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class PagoPlataformaRepository implements PagoPlataformaRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator
    {
        return PagoPlataforma::with(['facturaTenant', 'tenant'])
            ->latest()
            ->paginate($perPage);
    }

    public function findOrFail(int $id): PagoPlataforma
    {
        return PagoPlataforma::with(['facturaTenant', 'tenant'])
            ->findOrFail($id);
    }

    public function create(array $data): PagoPlataforma
    {
        return PagoPlataforma::create($data);
    }

    public function update(int $id, array $data): PagoPlataforma
    {
        $pago = PagoPlataforma::findOrFail($id);
        $pago->update($data);

        return $pago->fresh(['facturaTenant', 'tenant']);
    }

    public function delete(int $id): void
    {
        PagoPlataforma::findOrFail($id)->delete();
    }
}
