<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\MetodoPago;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface MetodoPagoRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator;
    public function findOrFail(int $id): MetodoPago;
    public function create(array $data): MetodoPago;
    public function update(int $id, array $data): MetodoPago;
    public function delete(int $id): void;
}
