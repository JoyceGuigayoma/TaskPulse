<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request, Project $project): RedirectResponse
    {
        abort_unless($project->workspace_id === currentWorkspace()->id, 403);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'due_date' => ['nullable', 'date'],
        ]);

        $project->tasks()->create([
            'title' => $request->title,
            'assigned_to' => $request->assigned_to,
            'due_date' => $request->due_date,
        ]);

        return back()->with('status', 'Task added!');
    }

    public function updateStatus(Request $request, Task $task): RedirectResponse
    {
        abort_unless($task->project->workspace_id === currentWorkspace()->id, 403);

        $request->validate([
            'status' => ['required', 'in:todo,in_progress,done'],
        ]);

        $task->update(['status' => $request->status]);

        return back()->with('status', 'Task updated!');
    }
}