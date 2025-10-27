<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class EnsureUserIsUmkmAdmin
{
    /**
     * Handle an incoming request.
     *
     * Checks:
     * - user must be authenticated
     * - superadmin bypass
     * - user's status must be 'approved'
     * - user's umkm_id must match route umkm id (if provided)
     *
     * Returns redirect for web requests and JSON responses for API requests.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // Not authenticated
        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('login');
        }

        // Superadmin bypass
        if (isset($user->role) && $user->role === 'superadmin') {
            return $next($request);
        }

        // Must be approved
        if (!isset($user->status) || $user->status !== 'approved') {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Account not approved.'], 403);
            }
            return redirect()->route('umkm.pending');
        }

        // Determine UMKM id from route parameter (supports model binding or plain id)
        $routeUmkm = $request->route('umkm') ?? $request->route('umkm_id') ?? null;

        if ($routeUmkm) {
            $routeUmkmId = is_object($routeUmkm) ? ($routeUmkm->id ?? null) : $routeUmkm;

            // If route provides umkm id and user's umkm_id doesn't match -> forbidden
            if (isset($user->umkm_id) && $user->umkm_id != $routeUmkmId) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Forbidden. You do not own this UMKM.'], 403);
                }
                abort(403, 'Anda tidak memiliki akses ke UMKM ini.');
            }
        }

        return $next($request);
    }
}
