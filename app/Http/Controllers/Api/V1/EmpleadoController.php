<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Empleado\StoreRequest;
use App\Http\Requests\Empleado\UpdateRequest;
use App\Http\Resources\EmpleadoResource;
use App\Services\EmpleadoService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class EmpleadoController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly EmpleadoService $empleadoService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = min($request->integer('per_page', 15), 100);
        return EmpleadoResource::collection(
            $this->empleadoService->getAll($perPage)
        );
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $empleado = $this->empleadoService->create($request->payload());
        return $this->created(new EmpleadoResource($empleado));
    }

    public function show(int $id): EmpleadoResource
    {
        return new EmpleadoResource($this->empleadoService->findOrFail($id));
    }

    public function update(UpdateRequest $request, int $id): EmpleadoResource
    {
        return new EmpleadoResource(
            $this->empleadoService->update($id, $request->payload())
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $this->empleadoService->delete($id);
        return $this->noContent();
    }
}
