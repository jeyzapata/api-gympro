<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Resolves the tenant from the X-Tenant header (slug) and initializes
 * stancl/tenancy so all subsequent DB queries hit the correct schema.
 *
 * This middleware MUST run before auth:sanctum because the users table
 * lives inside the tenant schema — Sanctum needs the schema set first.
 *
 * Flow: Request → X-Tenant header → lookup in public.tenants → initialize schema → auth.
 */
final class InitializeTenancy
{
    public function handle(Request $request, Closure $next): Response
    {
        $tenantSlug = $request->header('X-Tenant');

        if (! $tenantSlug) {
            return response()->json([
                'success' => false,
                'message' => 'Header X-Tenant es requerido.',
            ], 400);
        }

        /** @var Tenant|null $tenant */
        $tenant = Tenant::where('slug', $tenantSlug)->first();

        if (! $tenant) {
            return response()->json([
                'success' => false,
                'message' => 'Tenant no encontrado.',
            ], 404);
        }

        if (! $tenant->suscripcion_activa) {
            return response()->json([
                'success' => false,
                'message' => 'La suscripción del gimnasio no está activa.',
            ], 403);
        }

        tenancy()->initialize($tenant);

        return $next($request);
    }
}
