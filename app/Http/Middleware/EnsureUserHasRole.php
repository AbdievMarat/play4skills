<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserHasRole
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role): mixed
    {
        if (!$request->user()->hasRole($role)) {
            return redirect('/')->with('error', "You don't have {$role} access");
        }

        return $next($request);
    }
}
