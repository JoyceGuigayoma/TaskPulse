<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use App\Models\Workspace;

class ProjectPolicy
{
    /**
     * Determine whether the user can view any projects in the workspace.
     */
    public function viewAny(User $user, Workspace $workspace): bool
    {
        // Any member of the workspace can view the project list
        return $workspace->members()->where('users.id', $user->id)->exists();
    }

    /**
     * Determine whether the user can view a specific project.
     */
    public function view(User $user, Project $project): bool
    {
        // User must belong to the project's workspace
        return $project->workspace->members()->where('users.id', $user->id)->exists();
    }

    /**
     * Determine whether the user can create projects in the workspace.
     */
    public function create(User $user, Workspace $workspace): bool
    {
        $member = $workspace->members()->where('users.id', $user->id)->first();

        // Only Workspace Admins and Managers can create projects
        return $member && in_array($member->pivot->role, ['admin', 'manager']);
    }

    /**
     * Determine whether the user can update the project.
     */
    public function update(User $user, Project $project): bool
    {
        $workspace = $project->workspace;
        $member = $workspace->members()->where('users.id', $user->id)->first();

        // Only Workspace Admins and Managers can edit/update projects
        return $member && in_array($member->pivot->role, ['admin', 'manager']);
    }

    /**
     * Determine whether the user can delete the project.
     */
    public function delete(User $user, Project $project): bool
    {
        $workspace = $project->workspace;
        $member = $workspace->members()->where('users.id', $user->id)->first();

        // Only Workspace Admins can delete projects
        return $member && $member->pivot->role === 'admin';
    }
}