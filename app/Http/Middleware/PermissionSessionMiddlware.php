<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionSessionMiddlware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->check()) {
            if(auth()->user()->role != User::ROLE_SUPERUSER) {
                if(auth()->user()->reset_permission == 1) {
                    auth()->user()->resetPermissionSession();
                    auth()->user()->reset_permission = 0;
                    auth()->user()->save();
                }
            }
        }
        return $next($request);
    }
}
