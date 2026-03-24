<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\CategoriaEquipo;
use App\Repositories\Contracts\CategoriaEquipoRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class CategoriaEquipoRepository implements CategoriaEquipoRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator
    {
        return CategoriaEquipo::orderBy('nombre')->paginate($perPage);
    }

    public function findOrFail(int $id): CategoriaEquipo
    {
        return CategoriaEquipo::findOrFail($id);
    }

    public function create(array $data): CategoriaEquipo
    {
        return CategoriaEquipo::create($data);
    }

    public function update(int $id, array $data): CategoriaEquipo
    {
        $categoriaEquipo = $this->findOrFail($id);
        $categoriaEquipo->update($data);
        return $categoriaEquipo->fresh();
    }

    public function delete(int $id): void
    {
        CategoriaEquipo::findOrFail($id)->delete();
    }
}
