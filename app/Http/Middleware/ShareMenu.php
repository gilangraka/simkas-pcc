<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class ShareMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $role = DB::table('model_has_roles')
                ->where('model_id', Auth::id())
                ->pluck('role_id')[0];
            $list_menu = DB::table('role_has_permissions')
                ->where('role_id', $role)
                ->join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                ->get(['permissions.id', 'name', 'route']);

            Inertia::share('menus', $list_menu);
        }

        return $next($request);
    }
}
