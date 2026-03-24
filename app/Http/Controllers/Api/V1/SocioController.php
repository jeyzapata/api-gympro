<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Socio\StoreRequest;
use App\Http\Requests\Socio\UpdateRequest;
use App\Http\Resources\SocioResource;
use App\Services\SocioService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class SocioController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly SocioService $socioService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = min($request->integer('per_page', 15), 100);

        return SocioResource::collection(
            $this->socioService->getAll($perPage)
        );
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $socio = $this->socioService->create($request->payload());

        return $this->created(new SocioResource($socio));
    }

    public function show(int $id): SocioResource
    {
        return new SocioResource($this->socioService->findOrFail($id));
    }

    public function update(UpdateRequest $request, int $id): SocioResource
    {
        return new SocioResource(
            $this->socioService->update($id, $request->payload())
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $this->socioService->delete($id);

        return $this->noContent();
    }
}
