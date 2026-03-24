<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\PlanPlataforma\StorePlanPlataformaPayload;
use App\DTOs\PlanPlataforma\UpdatePlanPlataformaPayload;
use App\Models\PlanPlataforma;
use App\Repositories\Contracts\PlanPlataformaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class PlanPlataformaService
{
    public function __construct(
        private readonly PlanPlataformaRepositoryInterface $planPlataformaRepository
    ) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->planPlataformaRepository->all($perPage);
    }

    public function findOrFail(int $id): PlanPlataforma
    {
        return $this->planPlataformaRepository->findOrFail($id);
    }

    public function create(StorePlanPlataformaPayload $payload): PlanPlataforma
    {
        return DB::transaction(
            fn () => $this->planPlataformaRepository->create($payload->toArray())
        );
    }

    public function update(int $id, UpdatePlanPlataformaPayload $payload): PlanPlataforma
    {
        return DB::transaction(
            fn () => $this->planPlataformaRepository->update($id, $payload->toArray())
        );
    }

    public function delete(int $id): void
    {
        DB::transaction(fn () => $this->planPlataformaRepository->delete($id));
    }
}
