<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\PlanPrecio;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PlanPrecioRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator;
    public function findOrFail(int $id): PlanPrecio;
    public function create(array $data): PlanPrecio;
    public function update(int $id, array $data): PlanPrecio;
    public function delete(int $id): void;
}
