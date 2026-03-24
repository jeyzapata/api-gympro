<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

use App\Http\Resources\TenantResource;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class TenantController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $tenants = Tenant::all();

        return TenantResource::collection($tenants);
    }

    public function show(Request $request, Tenant $tenant): TenantResource
    {
        return new TenantResource($tenant);
    }
}
