<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $roleMap = [
            'admin' => 1,
            'team_lead' => 2,
            'team_member' => 3,
        ];

        $userRoleId = auth()->user()->role_id;

        // Convert role names to IDs
        $allowedRoleIds = collect($roles)->map(fn ($role) => $roleMap[$role] ?? null)->filter();

        if (!$allowedRoleIds->contains($userRoleId)) {
            abort(403);
        }

        return $next($request);
    }
}
