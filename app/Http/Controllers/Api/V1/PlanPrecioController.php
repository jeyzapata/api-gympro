<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanPrecio\StoreRequest;
use App\Http\Requests\PlanPrecio\UpdateRequest;
use App\Http\Resources\PlanPrecioResource;
use App\Services\PlanPrecioService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class PlanPrecioController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly PlanPrecioService $planPrecioService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = min($request->integer('per_page', 15), 100);

        return PlanPrecioResource::collection(
            $this->planPrecioService->getAll($perPage)
        );
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $planPrecio = $this->planPrecioService->create($request->payload());

        return $this->created(new PlanPrecioResource($planPrecio));
    }

    public function show(int $id): PlanPrecioResource
    {
        return new PlanPrecioResource($this->planPrecioService->findOrFail($id));
    }

    public function update(UpdateRequest $request, int $id): PlanPrecioResource
    {
        return new PlanPrecioResource(
            $this->planPrecioService->update($id, $request->payload())
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $this->planPrecioService->delete($id);

        return $this->noContent();
    }
}
