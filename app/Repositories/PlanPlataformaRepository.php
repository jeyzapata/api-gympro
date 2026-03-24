<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\PlanPlataforma;
use App\Repositories\Contracts\PlanPlataformaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class PlanPlataformaRepository implements PlanPlataformaRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator
    {
        return PlanPlataforma::orderBy('orden_display')
            ->paginate($perPage);
    }

    public function findOrFail(int $id): PlanPlataforma
    {
        return PlanPlataforma::findOrFail($id);
    }

    public function create(array $data): PlanPlataforma
    {
        return PlanPlataforma::create($data);
    }

    public function update(int $id, array $data): PlanPlataforma
    {
        $plan = $this->findOrFail($id);
        $plan->update($data);

        return $plan->fresh();
    }

    public function delete(int $id): void
    {
        PlanPlataforma::findOrFail($id)->delete();
    }
}
