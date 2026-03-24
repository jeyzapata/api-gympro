<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\Mantenimiento\StoreMantenimientoPayload;
use App\DTOs\Mantenimiento\UpdateMantenimientoPayload;
use App\Models\Mantenimiento;
use App\Repositories\Contracts\MantenimientoRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class MantenimientoService
{
    public function __construct(
        private readonly MantenimientoRepositoryInterface $mantenimientoRepository
    ) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->mantenimientoRepository->all($perPage);
    }

    public function findOrFail(int $id): Mantenimiento
    {
        return $this->mantenimientoRepository->findOrFail($id);
    }

    public function create(StoreMantenimientoPayload $payload): Mantenimiento
    {
        return DB::transaction(
            fn () => $this->mantenimientoRepository->create($payload->toArray())
        );
    }

    public function update(int $id, UpdateMantenimientoPayload $payload): Mantenimiento
    {
        return DB::transaction(
            fn () => $this->mantenimientoRepository->update($id, $payload->toArray())
        );
    }

    public function delete(int $id): void
    {
        DB::transaction(fn () => $this->mantenimientoRepository->delete($id));
    }
}
