<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\PlanPrecio\StorePlanPrecioPayload;
use App\DTOs\PlanPrecio\UpdatePlanPrecioPayload;
use App\Models\PlanPrecio;
use App\Repositories\Contracts\PlanPrecioRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class PlanPrecioService
{
    public function __construct(
        private readonly PlanPrecioRepositoryInterface $planPrecioRepository
    ) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->planPrecioRepository->all($perPage);
    }

    public function findOrFail(int $id): PlanPrecio
    {
        return $this->planPrecioRepository->findOrFail($id);
    }

    public function create(StorePlanPrecioPayload $payload): PlanPrecio
    {
        return DB::transaction(
            fn () => $this->planPrecioRepository->create($payload->toArray())
        );
    }

    public function update(int $id, UpdatePlanPrecioPayload $payload): PlanPrecio
    {
        return DB::transaction(
            fn () => $this->planPrecioRepository->update($id, $payload->toArray())
        );
    }

    public function delete(int $id): void
    {
        DB::transaction(fn () => $this->planPrecioRepository->delete($id));
    }
}
