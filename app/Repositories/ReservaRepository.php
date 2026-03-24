<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Reserva;
use App\Repositories\Contracts\ReservaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class ReservaRepository implements ReservaRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator
    {
        return Reserva::with(['turnoClase', 'socio', 'membresia'])
            ->latest()
            ->paginate($perPage);
    }

    public function findOrFail(int $id): Reserva
    {
        return Reserva::with(['turnoClase', 'socio', 'membresia'])->findOrFail($id);
    }

    public function create(array $data): Reserva
    {
        return Reserva::create($data);
    }

    public function update(int $id, array $data): Reserva
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->update($data);

        return $reserva->fresh(['turnoClase', 'socio', 'membresia']);
    }

    public function delete(int $id): void
    {
        Reserva::findOrFail($id)->delete();
    }
}
