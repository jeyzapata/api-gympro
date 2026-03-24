<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Promocion;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PromocionRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator;
    public function findOrFail(int $id): Promocion;
    public function create(array $data): Promocion;
    public function update(int $id, array $data): Promocion;
    public function delete(int $id): void;
}
