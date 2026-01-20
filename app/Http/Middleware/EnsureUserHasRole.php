<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  array<int, string>  $roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user || empty($roles)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $hasRole = collect($roles)->contains(fn (string $role) => $user->hasRole($role));

        abort_unless($hasRole, Response::HTTP_FORBIDDEN, 'Anda tidak memiliki akses ke halaman ini.');

        return $next($request);
    }
}
