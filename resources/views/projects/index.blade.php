<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Projects
            </h2>
            <button onclick="document.getElementById('create-project-modal').classList.remove('hidden')"
                class="px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700 transition">
                + New Project
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-4 px-4 py-3 rounded-lg bg-violet-50 text-violet-700 text-sm border border-violet-100">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 px-4 py-3 rounded-lg bg-red-50 text-red-700 text-sm border border-red-100">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($projects->isEmpty())
                <div class="bg-white rounded-2xl border border-dashed border-gray-200 p-12 text-center">
                    <p class="text-gray-500">No projects yet in <span class="font-medium">{{ currentWorkspace()->name }}</span>.</p>
                    <button onclick="document.getElementById('create-project-modal').classList.remove('hidden')"
                        class="mt-4 px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700 transition">
                        Create your first project
                    </button>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($projects as $project)
                        <a href="{{ route('projects.show', $project) }}"
                            class="block bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-indigo-200 transition p-5">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-semibold text-gray-900">{{ $project->title }}</h3>
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

    <!-- Create Project Modal -->
    <div id="create-project-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/40">
        <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-900 mb-1">New project</h3>
            <p class="text-sm text-gray-500 mb-4">Add a project to {{ currentWorkspace()->name }}.</p>
            <form method="POST" action="{{ route('projects.store') }}">
                @csrf
                <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input type="text" name="title" required placeholder="e.g. Website Redesign"
                    class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm mb-4" />

                <label class="block text-sm font-medium text-gray-700 mb-1">Description (optional)</label>
                <textarea name="description" rows="3" placeholder="What is this project about?"
                    class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm mb-4"></textarea>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('create-project-modal').classList.add('hidden')"
                        class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700 transition">
                        Create Project
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>