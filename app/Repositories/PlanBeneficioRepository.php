<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\PlanBeneficio;
use App\Repositories\Contracts\PlanBeneficioRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class PlanBeneficioRepository implements PlanBeneficioRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator
    {
        return PlanBeneficio::with(['plan'])->orderBy('orden')->paginate($perPage);
    }

    public function findOrFail(int $id): PlanBeneficio
    {
        return PlanBeneficio::with(['plan'])->findOrFail($id);
    }

    public function create(array $data): PlanBeneficio
    {
        return PlanBeneficio::create($data);
    }

    public function update(int $id, array $data): PlanBeneficio
    {
        $planBeneficio = $this->findOrFail($id);
        $planBeneficio->update($data);
        return $planBeneficio->fresh(['plan']);
    }

    public function delete(int $id): void
    {
        PlanBeneficio::findOrFail($id)->delete();
    }
}
