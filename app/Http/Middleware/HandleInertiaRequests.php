<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $role = DB::table('model_has_roles')
            ->where('model_id', auth()->id())
            ->pluck('role_id')[0];
        $list_menu = DB::table('role_has_permissions')
            ->where('role_id', $role)
            ->join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->get(['permissions.id', 'name', 'route']);

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'menus' => $list_menu
        ];
    }
}
