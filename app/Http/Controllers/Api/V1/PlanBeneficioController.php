<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanBeneficio\StoreRequest;
use App\Http\Requests\PlanBeneficio\UpdateRequest;
use App\Http\Resources\PlanBeneficioResource;
use App\Services\PlanBeneficioService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class PlanBeneficioController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly PlanBeneficioService $planBeneficioService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = min($request->integer('per_page', 15), 100);
        return PlanBeneficioResource::collection(
            $this->planBeneficioService->getAll($perPage)
        );
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $planBeneficio = $this->planBeneficioService->create($request->payload());
        return $this->created(new PlanBeneficioResource($planBeneficio));
    }

    public function show(int $id): PlanBeneficioResource
    {
        return new PlanBeneficioResource($this->planBeneficioService->findOrFail($id));
    }

    public function update(UpdateRequest $request, int $id): PlanBeneficioResource
    {
        return new PlanBeneficioResource(
            $this->planBeneficioService->update($id, $request->payload())
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $this->planBeneficioService->delete($id);
        return $this->noContent();
    }
}
