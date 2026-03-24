<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Caja;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CajaRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator;
    public function findOrFail(int $id): Caja;
    public function create(array $data): Caja;
    public function update(int $id, array $data): Caja;
    public function delete(int $id): void;
}
