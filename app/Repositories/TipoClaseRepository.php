<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\TipoClase;
use App\Repositories\Contracts\TipoClaseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class TipoClaseRepository implements TipoClaseRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator
    {
        return TipoClase::orderBy('nombre')->paginate($perPage);
    }

    public function findOrFail(int $id): TipoClase
    {
        return TipoClase::findOrFail($id);
    }

    public function create(array $data): TipoClase
    {
        return TipoClase::create($data);
    }

    public function update(int $id, array $data): TipoClase
    {
        $tipoClase = $this->findOrFail($id);
        $tipoClase->update($data);
        return $tipoClase->fresh();
    }

    public function delete(int $id): void
    {
        TipoClase::findOrFail($id)->delete();
    }
}
