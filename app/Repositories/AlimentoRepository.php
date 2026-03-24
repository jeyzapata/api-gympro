<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Alimento;
use App\Repositories\Contracts\AlimentoRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class AlimentoRepository implements AlimentoRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator
    {
        return Alimento::orderBy('nombre')->paginate($perPage);
    }

    public function findOrFail(int $id): Alimento
    {
        return Alimento::findOrFail($id);
    }

    public function create(array $data): Alimento
    {
        return Alimento::create($data);
    }

    public function update(int $id, array $data): Alimento
    {
        $alimento = $this->findOrFail($id);
        $alimento->update($data);
        return $alimento->fresh();
    }

    public function delete(int $id): void
    {
        Alimento::findOrFail($id)->delete();
    }
}
