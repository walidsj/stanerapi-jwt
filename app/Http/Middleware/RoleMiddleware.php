<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if ($request->user()->role != $role) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized. Your API Token role is invalid.',
            ], 401);
        }

        return $next($request);
    }
}
