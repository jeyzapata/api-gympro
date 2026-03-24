<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Sede;
use App\Repositories\Contracts\SedeRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class SedeRepository implements SedeRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator
    {
        return Sede::latest()->paginate($perPage);
    }

    public function findOrFail(int $id): Sede
    {
        return Sede::findOrFail($id);
    }

    public function create(array $data): Sede
    {
        return Sede::create($data);
    }

    public function update(int $id, array $data): Sede
    {
        $sede = $this->findOrFail($id);
        $sede->update($data);
        return $sede->fresh();
    }

    public function delete(int $id): void
    {
        Sede::findOrFail($id)->delete();
    }
}
