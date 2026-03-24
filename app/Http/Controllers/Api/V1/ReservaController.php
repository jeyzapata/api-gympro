<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reserva\StoreRequest;
use App\Http\Requests\Reserva\UpdateRequest;
use App\Http\Resources\ReservaResource;
use App\Services\ReservaService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class ReservaController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly ReservaService $reservaService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = min($request->integer('per_page', 15), 100);

        return ReservaResource::collection(
            $this->reservaService->getAll($perPage)
        );
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $reserva = $this->reservaService->create($request->payload());

        return $this->created(new ReservaResource($reserva));
    }

    public function show(int $id): ReservaResource
    {
        return new ReservaResource($this->reservaService->findOrFail($id));
    }

    public function update(UpdateRequest $request, int $id): ReservaResource
    {
        return new ReservaResource(
            $this->reservaService->update($id, $request->payload())
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $this->reservaService->delete($id);

        return $this->noContent();
    }
}
