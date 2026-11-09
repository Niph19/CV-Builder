<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $allowed = array_filter(array_map(UserRole::tryFrom(...), $roles));

        if ($request->user() === null || ! in_array($request->user()->role, $allowed, true)) {
            abort(403);
        }

        return $next($request);
    }
}
