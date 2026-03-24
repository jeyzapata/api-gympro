<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\Notificacion\StoreNotificacionPayload;
use App\DTOs\Notificacion\UpdateNotificacionPayload;
use App\Models\Notificacion;
use App\Repositories\Contracts\NotificacionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class NotificacionService
{
    public function __construct(
        private readonly NotificacionRepositoryInterface $notificacionRepository
    ) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->notificacionRepository->all($perPage);
    }

    public function findOrFail(int $id): Notificacion
    {
        return $this->notificacionRepository->findOrFail($id);
    }

    public function create(StoreNotificacionPayload $payload): Notificacion
    {
        return DB::transaction(
            fn () => $this->notificacionRepository->create($payload->toArray())
        );
    }

    public function update(int $id, UpdateNotificacionPayload $payload): Notificacion
    {
        return DB::transaction(
            fn () => $this->notificacionRepository->update($id, $payload->toArray())
        );
    }

    public function delete(int $id): void
    {
        DB::transaction(fn () => $this->notificacionRepository->delete($id));
    }
}
