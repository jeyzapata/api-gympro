<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\PlanPlataforma;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PlanPlataformaRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator;
    public function findOrFail(int $id): PlanPlataforma;
    public function create(array $data): PlanPlataforma;
    public function update(int $id, array $data): PlanPlataforma;
    public function delete(int $id): void;
}
