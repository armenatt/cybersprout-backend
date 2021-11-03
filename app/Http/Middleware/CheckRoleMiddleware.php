<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $roles = [
            'user' => [2, 1],
            'admin' => [2],
            'moderator' => [2, 3],
            'creator' => [2, 4]
        ];

        if (!in_array(Auth::user()->role, $roles[$role])) {
            return response([
                'message' => 'You don\'t have permissions for this action'
            ], 403);
        }
        return $next($request);
    }
}
