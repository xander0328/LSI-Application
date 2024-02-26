<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            // Redirect or return unauthorized response for guests
            return redirect()->route('home');
        }

        $user = auth()->user();

        if (!in_array($user->role, $roles)) {
            // Redirect or return unauthorized response for users without required role
            return redirect()->route('unauthorized');
        }

        return $next($request);
    }

}
