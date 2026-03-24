<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Caja\StoreRequest;
use App\Http\Requests\Caja\UpdateRequest;
use App\Http\Resources\CajaResource;
use App\Services\CajaService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class CajaController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly CajaService $cajaService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = min($request->integer('per_page', 15), 100);

        return CajaResource::collection(
            $this->cajaService->getAll($perPage)
        );
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $caja = $this->cajaService->create($request->payload());

        return $this->created(new CajaResource($caja));
    }

    public function show(int $id): CajaResource
    {
        return new CajaResource($this->cajaService->findOrFail($id));
    }

    public function update(UpdateRequest $request, int $id): CajaResource
    {
        return new CajaResource(
            $this->cajaService->update($id, $request->payload())
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $this->cajaService->delete($id);

        return $this->noContent();
    }
}
