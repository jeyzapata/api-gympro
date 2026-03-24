<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Asistencia\StoreRequest;
use App\Http\Requests\Asistencia\UpdateRequest;
use App\Http\Resources\AsistenciaResource;
use App\Services\AsistenciaService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class AsistenciaController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly AsistenciaService $asistenciaService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = min($request->integer('per_page', 15), 100);
        return AsistenciaResource::collection(
            $this->asistenciaService->getAll($perPage)
        );
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $asistencia = $this->asistenciaService->create($request->payload());
        return $this->created(new AsistenciaResource($asistencia));
    }

    public function show(int $id): AsistenciaResource
    {
        return new AsistenciaResource($this->asistenciaService->findOrFail($id));
    }

    public function update(UpdateRequest $request, int $id): AsistenciaResource
    {
        return new AsistenciaResource(
            $this->asistenciaService->update($id, $request->payload())
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $this->asistenciaService->delete($id);
        return $this->noContent();
    }
}
