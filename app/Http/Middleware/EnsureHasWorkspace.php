<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class EnsureHasWorkspace
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // Skip middleware for workspace creation routes to avoid infinite redirects
            if ($request->routeIs('workspaces.create') || $request->routeIs('workspaces.store')) {
                return $next($request);
            }

            if (! Session::has('workspace_id')) {
                $workspace = Auth::user()->workspaces()->first();

                if ($workspace) {
                    Session::put('workspace_id', $workspace->id);
                } else {
                    return redirect()->route('workspaces.create');
                }
            }
        }

        return $next($request);
    }
}
