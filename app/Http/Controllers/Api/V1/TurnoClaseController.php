<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TurnoClase\StoreRequest;
use App\Http\Requests\TurnoClase\UpdateRequest;
use App\Http\Resources\TurnoClaseResource;
use App\Services\TurnoClaseService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class TurnoClaseController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly TurnoClaseService $turnoClaseService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = min($request->integer('per_page', 15), 100);
        return TurnoClaseResource::collection(
            $this->turnoClaseService->getAll($perPage)
        );
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $turnoClase = $this->turnoClaseService->create($request->payload());
        return $this->created(new TurnoClaseResource($turnoClase));
    }

    public function show(int $id): TurnoClaseResource
    {
        return new TurnoClaseResource($this->turnoClaseService->findOrFail($id));
    }

    public function update(UpdateRequest $request, int $id): TurnoClaseResource
    {
        return new TurnoClaseResource(
            $this->turnoClaseService->update($id, $request->payload())
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $this->turnoClaseService->delete($id);
        return $this->noContent();
    }
}
