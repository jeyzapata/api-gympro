<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Notificacion;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface NotificacionRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator;
    public function findOrFail(int $id): Notificacion;
    public function create(array $data): Notificacion;
    public function update(int $id, array $data): Notificacion;
    public function delete(int $id): void;
}
