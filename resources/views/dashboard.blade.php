<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ currentWorkspace()->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @php
                $recentProjects = currentWorkspace()->projects()->withCount('tasks')->latest()->take(3)->get();
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <p class="text-sm text-gray-500">Projects</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ currentWorkspace()->projects()->count() }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <p class="text-sm text-gray-500">Team Members</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ currentWorkspace()->members()->count() }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <p class="text-sm text-gray-500">Your Role</p>
                    <p class="text-2xl font-bold text-indigo-600 mt-1 capitalize">{{ currentWorkspace()->roleFor(auth()->user()) }}</p>
                </div>
            </div>

            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-900">Recent Projects</h3>
                <a href="{{ route('projects.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                    View all &rarr;
                </a>
            </div>

            @if ($recentProjects->isEmpty())
                <div class="bg-white rounded-2xl border border-dashed border-gray-200 p-8 text-center">
                    <p class="text-gray-500 mb-3">No projects yet.</p>
                    <a href="{{ route('projects.index') }}"
                        class="inline-block px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700 transition">
                        Create your first project
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($recentProjects as $project)
                        <a href="{{ route('projects.show', $project) }}"
                            class="block bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-indigo-200 transition p-5">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-semibold text-gray-900">{{ $project->name }}</h4>
                                <span class="text-xs font-medium px-2 py-1 rounded-full bg-indigo-50 text-indigo-600">
                                    {{ $project->tasks_count }} {{ Str::plural('task', $project->tasks_count) }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-500 line-clamp-2">
                                {{ $project->description ?: 'No description yet.' }}
                            </p>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>