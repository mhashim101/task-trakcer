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
    public function handle(Request $request, Closure $next,  ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
    
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
            abort(403);
        }
    
        return $next($request);
    }
}
