<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\TurnoClase;
use App\Repositories\Contracts\TurnoClaseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class TurnoClaseRepository implements TurnoClaseRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator
    {
        return TurnoClase::with(['clase', 'instructor'])->latest()->paginate($perPage);
    }

    public function findOrFail(int $id): TurnoClase
    {
        return TurnoClase::with(['clase', 'instructor'])->findOrFail($id);
    }

    public function create(array $data): TurnoClase
    {
        return TurnoClase::create($data);
    }

    public function update(int $id, array $data): TurnoClase
    {
        $turnoClase = $this->findOrFail($id);
        $turnoClase->update($data);
        return $turnoClase->fresh(['clase', 'instructor']);
    }

    public function delete(int $id): void
    {
        TurnoClase::findOrFail($id)->delete();
    }
}
