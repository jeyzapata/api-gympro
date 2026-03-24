<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\PlanNutricional\StorePlanNutricionalPayload;
use App\DTOs\PlanNutricional\UpdatePlanNutricionalPayload;
use App\Models\PlanNutricional;
use App\Repositories\Contracts\PlanNutricionalRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class PlanNutricionalService
{
    public function __construct(
        private readonly PlanNutricionalRepositoryInterface $planNutricionalRepository
    ) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->planNutricionalRepository->all($perPage);
    }

    public function findOrFail(int $id): PlanNutricional
    {
        return $this->planNutricionalRepository->findOrFail($id);
    }

    public function create(StorePlanNutricionalPayload $payload): PlanNutricional
    {
        return DB::transaction(
            fn () => $this->planNutricionalRepository->create($payload->toArray())
        );
    }

    public function update(int $id, UpdatePlanNutricionalPayload $payload): PlanNutricional
    {
        return DB::transaction(
            fn () => $this->planNutricionalRepository->update($id, $payload->toArray())
        );
    }

    public function delete(int $id): void
    {
        DB::transaction(fn () => $this->planNutricionalRepository->delete($id));
    }
}
