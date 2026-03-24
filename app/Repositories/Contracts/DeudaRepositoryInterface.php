<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Deuda;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface DeudaRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator;
    public function findOrFail(int $id): Deuda;
    public function create(array $data): Deuda;
    public function update(int $id, array $data): Deuda;
    public function delete(int $id): void;
}
