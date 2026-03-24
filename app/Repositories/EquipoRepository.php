<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Equipo;
use App\Repositories\Contracts\EquipoRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class EquipoRepository implements EquipoRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator
    {
        return Equipo::with(['sede', 'categoriaEquipo'])
            ->latest()
            ->paginate($perPage);
    }

    public function findOrFail(int $id): Equipo
    {
        return Equipo::with(['sede', 'categoriaEquipo'])->findOrFail($id);
    }

    public function create(array $data): Equipo
    {
        $equipo = Equipo::create($data);

        return $equipo->load(['sede', 'categoriaEquipo']);
    }

    public function update(int $id, array $data): Equipo
    {
        $equipo = $this->findOrFail($id);
        $equipo->update($data);

        return $equipo->fresh(['sede', 'categoriaEquipo']);
    }

    public function delete(int $id): void
    {
        Equipo::findOrFail($id)->delete();
    }
}
