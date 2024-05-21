<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{

    /**
     * Handle an unauthenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  array  ...$guards
     * @return mixed
     */
    protected function redirectTo($request)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        // For web requests, you can redirect to a login page or return an error view.
        abort(401, 'Unauthenticated.');
    }

}
