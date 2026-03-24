<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Plan;
use App\Repositories\Contracts\PlanRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class PlanRepository implements PlanRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator
    {
        return Plan::with(['planPrecios', 'planBeneficios'])
            ->latest()
            ->paginate($perPage);
    }

    public function findOrFail(int $id): Plan
    {
        return Plan::with(['planPrecios', 'planBeneficios'])
            ->findOrFail($id);
    }

    public function create(array $data): Plan
    {
        return Plan::create($data);
    }

    public function update(int $id, array $data): Plan
    {
        $plan = $this->findOrFail($id);
        $plan->update($data);

        return $plan->fresh(['planPrecios', 'planBeneficios']);
    }

    public function delete(int $id): void
    {
        Plan::findOrFail($id)->delete();
    }
}
