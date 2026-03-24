<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Reserva;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ReservaRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator;
    public function findOrFail(int $id): Reserva;
    public function create(array $data): Reserva;
    public function update(int $id, array $data): Reserva;
    public function delete(int $id): void;
}
