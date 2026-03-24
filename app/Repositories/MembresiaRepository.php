<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Membresia;
use App\Repositories\Contracts\MembresiaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class MembresiaRepository implements MembresiaRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator
    {
        return Membresia::with(['socio', 'plan', 'planPrecio', 'sede'])
            ->latest()
            ->paginate($perPage);
    }

    public function findOrFail(int $id): Membresia
    {
        return Membresia::with(['socio', 'plan', 'planPrecio', 'sede'])->findOrFail($id);
    }

    public function create(array $data): Membresia
    {
        return Membresia::create($data);
    }

    public function update(int $id, array $data): Membresia
    {
        $membresia = Membresia::findOrFail($id);
        $membresia->update($data);

        return $membresia->fresh(['socio', 'plan', 'planPrecio', 'sede']);
    }

    public function delete(int $id): void
    {
        Membresia::findOrFail($id)->delete();
    }
}
