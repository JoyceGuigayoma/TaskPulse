<?php

namespace App\Http\Controllers;

use App\Models\Workspace;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WorkspaceController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $workspace = Workspace::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name).'-'.Str::random(6),
            'owner_id' => $request->user()->id,
        ]);

        $workspace->members()->attach($request->user()->id, ['role' => 'admin']);

        session(['current_workspace_id' => $workspace->id]);

        return redirect()->route('dashboard')->with('status', 'Workspace created!');
    }

    public function switch(Workspace $workspace, Request $request): RedirectResponse
    {
        abort_unless(
            $workspace->members()->where('user_id', $request->user()->id)->exists(),
            403
        );

        session(['current_workspace_id' => $workspace->id]);

        return redirect()->route('dashboard');
    }
}