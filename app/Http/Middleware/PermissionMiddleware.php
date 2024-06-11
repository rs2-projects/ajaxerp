<?php

namespace App\Http\Middleware;

use App\Models\Permission\RolePermission;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        if(!auth()->check()) {
            return redirect()->route('login');
        }
        if (auth()->user()->role != User::ROLE_SUPERUSER) {
            $role_id = auth()->user()->role_id;
            $check = RolePermission::where('role_id', $role_id)
                ->whereIn('permission', $permissions)
                ->first();
            if (empty($check)) {
                if ($request->ajax()) {
                    return response()->json([
                        'status' => 403,
                        'message' => 'You do not have permission to access this page.'
                    ]);
                }
                return redirect()->back()->with(['failed' => 'You do not have permission to access this page.']);
            }
        }

        return $next($request);
    }
}
