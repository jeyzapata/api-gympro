<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\PlanBeneficio\StorePlanBeneficioPayload;
use App\DTOs\PlanBeneficio\UpdatePlanBeneficioPayload;
use App\Models\PlanBeneficio;
use App\Repositories\Contracts\PlanBeneficioRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class PlanBeneficioService
{
    public function __construct(
        private readonly PlanBeneficioRepositoryInterface $planBeneficioRepository
    ) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->planBeneficioRepository->all($perPage);
    }

    public function findOrFail(int $id): PlanBeneficio
    {
        return $this->planBeneficioRepository->findOrFail($id);
    }

    public function create(StorePlanBeneficioPayload $payload): PlanBeneficio
    {
        return DB::transaction(
            fn () => $this->planBeneficioRepository->create($payload->toArray())
        );
    }

    public function update(int $id, UpdatePlanBeneficioPayload $payload): PlanBeneficio
    {
        return DB::transaction(
            fn () => $this->planBeneficioRepository->update($id, $payload->toArray())
        );
    }

    public function delete(int $id): void
    {
        DB::transaction(fn () => $this->planBeneficioRepository->delete($id));
    }
}
