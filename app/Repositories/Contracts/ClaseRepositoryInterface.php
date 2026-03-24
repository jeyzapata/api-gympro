<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Clase;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ClaseRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator;
    public function findOrFail(int $id): Clase;
    public function create(array $data): Clase;
    public function update(int $id, array $data): Clase;
    public function delete(int $id): void;
}
