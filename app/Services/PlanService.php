<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\Plan\StorePlanPayload;
use App\DTOs\Plan\UpdatePlanPayload;
use App\Models\Plan;
use App\Repositories\Contracts\PlanRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class PlanService
{
    public function __construct(
        private readonly PlanRepositoryInterface $planRepository
    ) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->planRepository->all($perPage);
    }

    public function findOrFail(int $id): Plan
    {
        return $this->planRepository->findOrFail($id);
    }

    public function create(StorePlanPayload $payload): Plan
    {
        return DB::transaction(
            fn () => $this->planRepository->create($payload->toArray())
        );
    }

    public function update(int $id, UpdatePlanPayload $payload): Plan
    {
        return DB::transaction(
            fn () => $this->planRepository->update($id, $payload->toArray())
        );
    }

    public function delete(int $id): void
    {
        DB::transaction(fn () => $this->planRepository->delete($id));
    }
}
