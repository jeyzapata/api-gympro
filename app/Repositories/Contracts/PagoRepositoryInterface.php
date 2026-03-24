<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Pago;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PagoRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator;
    public function findOrFail(int $id): Pago;
    public function create(array $data): Pago;
    public function update(int $id, array $data): Pago;
    public function delete(int $id): void;
}
