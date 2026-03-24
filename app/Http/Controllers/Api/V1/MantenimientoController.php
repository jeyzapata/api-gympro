<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mantenimiento\StoreRequest;
use App\Http\Requests\Mantenimiento\UpdateRequest;
use App\Http\Resources\MantenimientoResource;
use App\Services\MantenimientoService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class MantenimientoController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly MantenimientoService $mantenimientoService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = min($request->integer('per_page', 15), 100);

        return MantenimientoResource::collection(
            $this->mantenimientoService->getAll($perPage)
        );
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $mantenimiento = $this->mantenimientoService->create($request->payload());

        return $this->created(new MantenimientoResource($mantenimiento));
    }

    public function show(int $id): MantenimientoResource
    {
        return new MantenimientoResource($this->mantenimientoService->findOrFail($id));
    }

    public function update(UpdateRequest $request, int $id): MantenimientoResource
    {
        return new MantenimientoResource(
            $this->mantenimientoService->update($id, $request->payload())
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $this->mantenimientoService->delete($id);

        return $this->noContent();
    }
}
