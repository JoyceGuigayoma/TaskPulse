<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('projects.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">&larr; Projects</a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight mt-1">
                    {{ $project->name }}
                </h2>
            </div>
            <button onclick="document.getElementById('create-task-modal').classList.remove('hidden')"
                class="px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700 transition">
                + Add Task
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

            @php
                $columns = [
                    'todo' => ['label' => 'To Do', 'color' => 'bg-gray-100 text-gray-600'],
                    'in_progress' => ['label' => 'In Progress', 'color' => 'bg-amber-100 text-amber-700'],
                    'done' => ['label' => 'Done', 'color' => 'bg-emerald-100 text-emerald-700'],
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                @foreach ($columns as $status => $meta)
                    <div class="bg-gray-50 rounded-2xl p-4">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-xs font-semibold px-2 py-1 rounded-full {{ $meta['color'] }}">
                                {{ $meta['label'] }}
                            </span>
                            <span class="text-xs text-gray-400">
                                {{ $project->tasks->where('status', $status)->count() }}
                            </span>
                        </div>

                        <div class="space-y-3">
                            @forelse ($project->tasks->where('status', $status) as $task)
                                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
                                    <p class="text-sm font-medium text-gray-900 mb-2">{{ $task->title }}</p>

                                    <div class="flex items-center justify-between text-xs text-gray-500">
                                        <span>
                                            @if ($task->assignee)
                                                👤 {{ $task->assignee->name }}
                                            @else
                                                Unassigned
                                            @endif
                                        </span>
                                        @if ($task->due_date)
                                            <span>{{ $task->due_date->format('M j') }}</span>
                                        @endif
                                    </div>

                                    <form method="POST" action="{{ route('tasks.updateStatus', $task) }}" class="mt-3">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()"
                                            class="w-full text-xs rounded-lg border-gray-200 focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="todo" @selected($task->status === 'todo')>To Do</option>
                                            <option value="in_progress" @selected($task->status === 'in_progress')>In Progress</option>
                                            <option value="done" @selected($task->status === 'done')>Done</option>
                                        </select>
                                    </form>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 italic">No tasks here.</p>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Add Task Modal -->
    <div id="create-task-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/40">
        <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Add a task</h3>
            <form method="POST" action="{{ route('tasks.store', $project) }}">
                @csrf
                <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input type="text" name="title" required placeholder="e.g. Design the homepage"
                    class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm mb-4" />

                <label class="block text-sm font-medium text-gray-700 mb-1">Assign to</label>
                <select name="assigned_to" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm mb-4">
                    <option value="">Unassigned</option>
                    @foreach ($members as $member)
                        <option value="{{ $member->id }}">{{ $member->name }}</option>
                    @endforeach
                </select>

                <label class="block text-sm font-medium text-gray-700 mb-1">Due date (optional)</label>
                <input type="date" name="due_date"
                    class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm mb-4" />

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('create-task-modal').classList.add('hidden')"
                        class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700 transition">
                        Add Task
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>