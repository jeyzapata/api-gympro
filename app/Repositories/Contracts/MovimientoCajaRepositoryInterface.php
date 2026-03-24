<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\MovimientoCaja;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface MovimientoCajaRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator;
    public function findOrFail(int $id): MovimientoCaja;
    public function create(array $data): MovimientoCaja;
    public function update(int $id, array $data): MovimientoCaja;
    public function delete(int $id): void;
}
