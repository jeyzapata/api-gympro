<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Sede;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface SedeRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator;
    public function findOrFail(int $id): Sede;
    public function create(array $data): Sede;
    public function update(int $id, array $data): Sede;
    public function delete(int $id): void;
}
