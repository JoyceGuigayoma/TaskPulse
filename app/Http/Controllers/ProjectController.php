<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $projects = currentWorkspace()->projects()->withCount('tasks')->latest()->get();

        return view('projects.index', [
            'projects' => $projects,
        ]);
    }

    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'title' => ['required', 'string', 'max:255'],
        'description' => ['nullable', 'string', 'max:2000'],
    ]);

    currentWorkspace()->projects()->create([
        'title' => $request->title,
        'description' => $request->description,
    ]);

    return redirect()->route('projects.index')->with('status', 'Project created!');
}
    public function show(Project $project): View
    {
        abort_unless($project->workspace_id === currentWorkspace()->id, 403);

        $project->load(['tasks.assignee']);

        return view('projects.show', [
            'project' => $project,
            'members' => currentWorkspace()->members,
        ]);
    }
}