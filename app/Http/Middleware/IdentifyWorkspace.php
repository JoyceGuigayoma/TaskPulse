<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IdentifyWorkspace
{
    /**
     * Resolve the authenticated user's active workspace, store it in the
     * session, bind it into the container, and share it with every view.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return $next($request);
        }

        $workspaceId = session('current_workspace_id');

        $workspace = $workspaceId
            ? $user->workspaces()->where('workspaces.id', $workspaceId)->first()
            : null;

        if (! $workspace) {
            $workspace = $user->workspaces()->first();
        }

        if ($workspace) {
            session(['current_workspace_id' => $workspace->id]);
            app()->instance('currentWorkspace', $workspace);
            view()->share('currentWorkspace', $workspace);
            view()->share('userWorkspaces', $user->workspaces()->get());
        }

        return $next($request);
    }
}