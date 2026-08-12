<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureWorkspaceIsSubscribed
{
    public function handle(Request $request, Closure $next): Response
    {
        $workspace = $request->route('workspace');

        // Check if workspace subscription is active or within trial
        if (! $workspace || ! $workspace->subscribed('default')) {
            return redirect()->route('billing.index', $workspace)
                ->with('error', 'Upgrade to a Pro plan to access this feature.');
        }

        return $next($request);
    }
}