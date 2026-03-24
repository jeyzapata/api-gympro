<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Plan;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PlanRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator;
    public function findOrFail(int $id): Plan;
    public function create(array $data): Plan;
    public function update(int $id, array $data): Plan;
    public function delete(int $id): void;
}
