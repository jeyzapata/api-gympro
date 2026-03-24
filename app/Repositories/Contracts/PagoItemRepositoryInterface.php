<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\PagoItem;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PagoItemRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator;
    public function findOrFail(int $id): PagoItem;
    public function create(array $data): PagoItem;
    public function update(int $id, array $data): PagoItem;
    public function delete(int $id): void;
}
