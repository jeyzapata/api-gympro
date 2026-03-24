<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\ComidaDiaria;
use App\Repositories\Contracts\ComidaDiariaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class ComidaDiariaRepository implements ComidaDiariaRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator
    {
        return ComidaDiaria::with(['planNutricional'])->orderByDesc('created_at')->paginate($perPage);
    }

    public function findOrFail(int $id): ComidaDiaria
    {
        return ComidaDiaria::with(['planNutricional'])->findOrFail($id);
    }

    public function create(array $data): ComidaDiaria
    {
        return ComidaDiaria::create($data);
    }

    public function update(int $id, array $data): ComidaDiaria
    {
        $comidaDiaria = $this->findOrFail($id);
        $comidaDiaria->update($data);
        return $comidaDiaria->fresh(['planNutricional']);
    }

    public function delete(int $id): void
    {
        ComidaDiaria::findOrFail($id)->delete();
    }
}
