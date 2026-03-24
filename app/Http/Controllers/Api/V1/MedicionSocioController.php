<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\MedicionSocio\StoreRequest;
use App\Http\Requests\MedicionSocio\UpdateRequest;
use App\Http\Resources\MedicionSocioResource;
use App\Services\MedicionSocioService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class MedicionSocioController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly MedicionSocioService $medicionSocioService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = min($request->integer('per_page', 15), 100);
        return MedicionSocioResource::collection(
            $this->medicionSocioService->getAll($perPage)
        );
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $medicionSocio = $this->medicionSocioService->create($request->payload());
        return $this->created(new MedicionSocioResource($medicionSocio));
    }

    public function show(int $id): MedicionSocioResource
    {
        return new MedicionSocioResource($this->medicionSocioService->findOrFail($id));
    }

    public function update(UpdateRequest $request, int $id): MedicionSocioResource
    {
        return new MedicionSocioResource(
            $this->medicionSocioService->update($id, $request->payload())
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $this->medicionSocioService->delete($id);
        return $this->noContent();
    }
}
