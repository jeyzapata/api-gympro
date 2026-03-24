<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Equipo\StoreRequest;
use App\Http\Requests\Equipo\UpdateRequest;
use App\Http\Resources\EquipoResource;
use App\Services\EquipoService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class EquipoController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly EquipoService $equipoService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = min($request->integer('per_page', 15), 100);

        return EquipoResource::collection(
            $this->equipoService->getAll($perPage)
        );
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $equipo = $this->equipoService->create($request->payload());

        return $this->created(new EquipoResource($equipo));
    }

    public function show(int $id): EquipoResource
    {
        return new EquipoResource($this->equipoService->findOrFail($id));
    }

    public function update(UpdateRequest $request, int $id): EquipoResource
    {
        return new EquipoResource(
            $this->equipoService->update($id, $request->payload())
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $this->equipoService->delete($id);

        return $this->noContent();
    }
}
