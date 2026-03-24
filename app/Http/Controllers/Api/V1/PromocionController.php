<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Promocion\StoreRequest;
use App\Http\Requests\Promocion\UpdateRequest;
use App\Http\Resources\PromocionResource;
use App\Services\PromocionService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class PromocionController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly PromocionService $promocionService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = min($request->integer('per_page', 15), 100);

        return PromocionResource::collection(
            $this->promocionService->getAll($perPage)
        );
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $promocion = $this->promocionService->create($request->payload());

        return $this->created(new PromocionResource($promocion));
    }

    public function show(int $id): PromocionResource
    {
        return new PromocionResource($this->promocionService->findOrFail($id));
    }

    public function update(UpdateRequest $request, int $id): PromocionResource
    {
        return new PromocionResource(
            $this->promocionService->update($id, $request->payload())
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $this->promocionService->delete($id);

        return $this->noContent();
    }
}
