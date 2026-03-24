<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Socio;
use App\Repositories\Contracts\SocioRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class SocioRepository implements SocioRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator
    {
        return Socio::with('sede')->latest()->paginate($perPage);
    }

    public function findOrFail(int $id): Socio
    {
        return Socio::with(['sede', 'referidoPor'])->findOrFail($id);
    }

    public function create(array $data): Socio
    {
        return Socio::create($data);
    }

    public function update(int $id, array $data): Socio
    {
        $socio = Socio::findOrFail($id);
        $socio->update($data);

        return $socio->fresh(['sede', 'referidoPor']);
    }

    public function delete(int $id): void
    {
        Socio::findOrFail($id)->delete();
    }
}
