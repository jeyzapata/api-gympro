<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Clase;
use App\Repositories\Contracts\ClaseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class ClaseRepository implements ClaseRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator
    {
        return Clase::with(['sede', 'tipoClase', 'empleado'])
            ->latest()
            ->paginate($perPage);
    }

    public function findOrFail(int $id): Clase
    {
        return Clase::with(['sede', 'tipoClase', 'empleado'])
            ->findOrFail($id);
    }

    public function create(array $data): Clase
    {
        $clase = Clase::create($data);

        return $clase->load(['sede', 'tipoClase', 'empleado']);
    }

    public function update(int $id, array $data): Clase
    {
        $clase = $this->findOrFail($id);
        $clase->update($data);

        return $clase->fresh(['sede', 'tipoClase', 'empleado']);
    }

    public function delete(int $id): void
    {
        Clase::findOrFail($id)->delete();
    }
}
