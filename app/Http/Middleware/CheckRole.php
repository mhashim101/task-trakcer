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
<<<<<<< HEAD
    public function handle(Request $request, Closure $next,  ...$roles): Response
=======
    public function handle(Request $request, Closure $next, ...$roles): Response
>>>>>>> 7a6e778683d6a30636388f0cf29f63f3305b9925
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
<<<<<<< HEAD
    
        $userRoleId = auth()->user()->role_id;
        $allowedRoleIds = [];
        
        foreach ($roles as $role) {
            $roleId = match($role) {
                'admin' => 1,
                'team_lead' => 2,
                'team_member' => 3,
                default => null,
            };
            if ($roleId) {
                $allowedRoleIds[] = $roleId;
            }
        }
    
        if (!in_array($userRoleId, $allowedRoleIds)) {
=======

        $roleMap = [
            'admin' => 1,
            'team_lead' => 2,
            'team_member' => 3,
        ];

        $userRoleId = auth()->user()->role_id;

        // Convert role names to IDs
        $allowedRoleIds = collect($roles)->map(fn ($role) => $roleMap[$role] ?? null)->filter();

        if (!$allowedRoleIds->contains($userRoleId)) {
>>>>>>> 7a6e778683d6a30636388f0cf29f63f3305b9925
            abort(403);
        }
    
        return $next($request);
    }
}
