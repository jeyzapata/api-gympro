<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notificacion\StoreRequest;
use App\Http\Requests\Notificacion\UpdateRequest;
use App\Http\Resources\NotificacionResource;
use App\Services\NotificacionService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class NotificacionController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly NotificacionService $notificacionService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = min($request->integer('per_page', 15), 100);
        return NotificacionResource::collection(
            $this->notificacionService->getAll($perPage)
        );
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $notificacion = $this->notificacionService->create($request->payload());
        return $this->created(new NotificacionResource($notificacion));
    }

    public function show(int $id): NotificacionResource
    {
        return new NotificacionResource($this->notificacionService->findOrFail($id));
    }

    public function update(UpdateRequest $request, int $id): NotificacionResource
    {
        return new NotificacionResource(
            $this->notificacionService->update($id, $request->payload())
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $this->notificacionService->delete($id);
        return $this->noContent();
    }
}
