<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Asistencia;
use App\Repositories\Contracts\AsistenciaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class AsistenciaRepository implements AsistenciaRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator
    {
        return Asistencia::with(['socio', 'sede', 'turnoClase', 'membresia'])
            ->latest()
            ->paginate($perPage);
    }

    public function findOrFail(int $id): Asistencia
    {
        return Asistencia::with(['socio', 'sede', 'turnoClase', 'membresia'])->findOrFail($id);
    }

    public function create(array $data): Asistencia
    {
        return Asistencia::create($data);
    }

    public function update(int $id, array $data): Asistencia
    {
        $asistencia = Asistencia::findOrFail($id);
        $asistencia->update($data);

        return $asistencia->fresh(['socio', 'sede', 'turnoClase', 'membresia']);
    }

    public function delete(int $id): void
    {
        Asistencia::findOrFail($id)->delete();
    }
}
