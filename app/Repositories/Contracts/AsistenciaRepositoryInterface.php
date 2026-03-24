<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Asistencia;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AsistenciaRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator;
    public function findOrFail(int $id): Asistencia;
    public function create(array $data): Asistencia;
    public function update(int $id, array $data): Asistencia;
    public function delete(int $id): void;
}
