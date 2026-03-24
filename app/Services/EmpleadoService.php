<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\Empleado\StoreEmpleadoPayload;
use App\DTOs\Empleado\UpdateEmpleadoPayload;
use App\Models\Empleado;
use App\Repositories\Contracts\EmpleadoRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class EmpleadoService
{
    public function __construct(
        private readonly EmpleadoRepositoryInterface $empleadoRepository
    ) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->empleadoRepository->all($perPage);
    }

    public function findOrFail(int $id): Empleado
    {
        return $this->empleadoRepository->findOrFail($id);
    }

    public function create(StoreEmpleadoPayload $payload): Empleado
    {
        return DB::transaction(
            fn () => $this->empleadoRepository->create($payload->toArray())
        );
    }

    public function update(int $id, UpdateEmpleadoPayload $payload): Empleado
    {
        return DB::transaction(
            fn () => $this->empleadoRepository->update($id, $payload->toArray())
        );
    }

    public function delete(int $id): void
    {
        DB::transaction(fn () => $this->empleadoRepository->delete($id));
    }
}
