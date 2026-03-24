<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Membresia;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface MembresiaRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator;
    public function findOrFail(int $id): Membresia;
    public function create(array $data): Membresia;
    public function update(int $id, array $data): Membresia;
    public function delete(int $id): void;
}
