<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanNutricional\StoreRequest;
use App\Http\Requests\PlanNutricional\UpdateRequest;
use App\Http\Resources\PlanNutricionalResource;
use App\Services\PlanNutricionalService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class PlanNutricionalController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly PlanNutricionalService $planNutricionalService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = min($request->integer('per_page', 15), 100);
        return PlanNutricionalResource::collection(
            $this->planNutricionalService->getAll($perPage)
        );
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $planNutricional = $this->planNutricionalService->create($request->payload());
        return $this->created(new PlanNutricionalResource($planNutricional));
    }

    public function show(int $id): PlanNutricionalResource
    {
        return new PlanNutricionalResource($this->planNutricionalService->findOrFail($id));
    }

    public function update(UpdateRequest $request, int $id): PlanNutricionalResource
    {
        return new PlanNutricionalResource(
            $this->planNutricionalService->update($id, $request->payload())
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $this->planNutricionalService->delete($id);
        return $this->noContent();
    }
}
