<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Empleado;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface EmpleadoRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator;
    public function findOrFail(int $id): Empleado;
    public function create(array $data): Empleado;
    public function update(int $id, array $data): Empleado;
    public function delete(int $id): void;
}
