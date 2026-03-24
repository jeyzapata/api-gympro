<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\Deuda\StoreDeudaPayload;
use App\DTOs\Deuda\UpdateDeudaPayload;
use App\Models\Deuda;
use App\Repositories\Contracts\DeudaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class DeudaService
{
    public function __construct(
        private readonly DeudaRepositoryInterface $deudaRepository
    ) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->deudaRepository->all($perPage);
    }

    public function findOrFail(int $id): Deuda
    {
        return $this->deudaRepository->findOrFail($id);
    }

    public function create(StoreDeudaPayload $payload): Deuda
    {
        return DB::transaction(
            fn () => $this->deudaRepository->create($payload->toArray())
        );
    }

    public function update(int $id, UpdateDeudaPayload $payload): Deuda
    {
        return DB::transaction(
            fn () => $this->deudaRepository->update($id, $payload->toArray())
        );
    }

    public function delete(int $id): void
    {
        DB::transaction(fn () => $this->deudaRepository->delete($id));
    }
}
