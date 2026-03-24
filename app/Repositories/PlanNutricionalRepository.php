<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\PlanNutricional;
use App\Repositories\Contracts\PlanNutricionalRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class PlanNutricionalRepository implements PlanNutricionalRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator
    {
        return PlanNutricional::with(['socio', 'empleado'])
            ->latest()
            ->paginate($perPage);
    }

    public function findOrFail(int $id): PlanNutricional
    {
        return PlanNutricional::with(['socio', 'empleado'])->findOrFail($id);
    }

    public function create(array $data): PlanNutricional
    {
        return PlanNutricional::create($data);
    }

    public function update(int $id, array $data): PlanNutricional
    {
        $planNutricional = PlanNutricional::findOrFail($id);
        $planNutricional->update($data);

        return $planNutricional->fresh(['socio', 'empleado']);
    }

    public function delete(int $id): void
    {
        PlanNutricional::findOrFail($id)->delete();
    }
}
