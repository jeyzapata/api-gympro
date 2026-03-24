<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\PlanBeneficio;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PlanBeneficioRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator;
    public function findOrFail(int $id): PlanBeneficio;
    public function create(array $data): PlanBeneficio;
    public function update(int $id, array $data): PlanBeneficio;
    public function delete(int $id): void;
}
