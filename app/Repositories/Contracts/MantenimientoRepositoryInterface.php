<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Mantenimiento;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface MantenimientoRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator;
    public function findOrFail(int $id): Mantenimiento;
    public function create(array $data): Mantenimiento;
    public function update(int $id, array $data): Mantenimiento;
    public function delete(int $id): void;
}
