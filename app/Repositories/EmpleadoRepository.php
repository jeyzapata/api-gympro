<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Empleado;
use App\Repositories\Contracts\EmpleadoRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class EmpleadoRepository implements EmpleadoRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator
    {
        return Empleado::with(['sede', 'rol'])->latest()->paginate($perPage);
    }

    public function findOrFail(int $id): Empleado
    {
        return Empleado::with(['sede', 'rol'])->findOrFail($id);
    }

    public function create(array $data): Empleado
    {
        return Empleado::create($data);
    }

    public function update(int $id, array $data): Empleado
    {
        $empleado = $this->findOrFail($id);
        $empleado->update($data);
        return $empleado->fresh(['sede', 'rol']);
    }

    public function delete(int $id): void
    {
        Empleado::findOrFail($id)->delete();
    }
}
