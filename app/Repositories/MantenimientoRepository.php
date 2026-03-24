<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Mantenimiento;
use App\Repositories\Contracts\MantenimientoRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class MantenimientoRepository implements MantenimientoRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator
    {
        return Mantenimiento::with(['equipo', 'empleado'])
            ->latest()
            ->paginate($perPage);
    }

    public function findOrFail(int $id): Mantenimiento
    {
        return Mantenimiento::with(['equipo', 'empleado'])->findOrFail($id);
    }

    public function create(array $data): Mantenimiento
    {
        $mantenimiento = Mantenimiento::create($data);

        return $mantenimiento->load(['equipo', 'empleado']);
    }

    public function update(int $id, array $data): Mantenimiento
    {
        $mantenimiento = $this->findOrFail($id);
        $mantenimiento->update($data);

        return $mantenimiento->fresh(['equipo', 'empleado']);
    }

    public function delete(int $id): void
    {
        Mantenimiento::findOrFail($id)->delete();
    }
}
