<?php

use App\Models\Workspace;

if (! function_exists('currentWorkspace')) {
    /**
     * Get the currently active workspace for the authenticated user.
     * Set by the IdentifyWorkspace middleware on every authenticated request.
     */
    function currentWorkspace(): ?Workspace
    {
        return app()->bound('currentWorkspace') ? app('currentWorkspace') : null;
    }
}