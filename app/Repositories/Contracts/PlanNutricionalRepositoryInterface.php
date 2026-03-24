<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\PlanNutricional;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PlanNutricionalRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator;
    public function findOrFail(int $id): PlanNutricional;
    public function create(array $data): PlanNutricional;
    public function update(int $id, array $data): PlanNutricional;
    public function delete(int $id): void;
}
