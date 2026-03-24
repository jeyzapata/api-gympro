<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Notificacion;
use App\Repositories\Contracts\NotificacionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class NotificacionRepository implements NotificacionRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator
    {
        return Notificacion::with(['user'])
            ->latest()
            ->paginate($perPage);
    }

    public function findOrFail(int $id): Notificacion
    {
        return Notificacion::with(['user'])->findOrFail($id);
    }

    public function create(array $data): Notificacion
    {
        return Notificacion::create($data);
    }

    public function update(int $id, array $data): Notificacion
    {
        $notificacion = Notificacion::findOrFail($id);
        $notificacion->update($data);

        return $notificacion->fresh(['user']);
    }

    public function delete(int $id): void
    {
        Notificacion::findOrFail($id)->delete();
    }
}
