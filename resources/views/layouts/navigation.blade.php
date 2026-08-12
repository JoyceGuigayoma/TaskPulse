<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Workspace Switcher -->
                @if (isset($currentWorkspace))
                    <div class="ms-6" x-data="{ workspaceOpen: false, createOpen: false }">
                        <div class="relative">
                            <button @click="workspaceOpen = ! workspaceOpen"
                                class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-200 bg-white text-sm font-medium text-gray-700 hover:border-indigo-300 hover:bg-indigo-50 transition">
                                <span class="h-2 w-2 rounded-full bg-violet-500"></span>
                                {{ $currentWorkspace->name }}
                                <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div x-show="workspaceOpen" @click.outside="workspaceOpen = false" x-transition
                                class="absolute left-0 mt-2 w-64 rounded-xl shadow-lg bg-white border border-gray-100 py-2 z-50" style="display: none;">
                                <div class="px-3 pb-2 mb-1 border-b border-gray-100 text-xs font-semibold text-gray-400 uppercase tracking-wide">
                                    Your Workspaces
                                </div>

                                @foreach ($userWorkspaces as $ws)
                                    <form method="POST" action="{{ route('workspaces.switch', $ws) }}">
                                        @csrf
                                        <button type="submit"
                                            class="w-full flex items-center gap-2 px-3 py-2 text-sm text-left hover:bg-indigo-50 transition {{ $ws->id === $currentWorkspace->id ? 'text-indigo-700 font-semibold' : 'text-gray-700' }}">
                                            <span class="h-1.5 w-1.5 rounded-full {{ $ws->id === $currentWorkspace->id ? 'bg-violet-500' : 'bg-gray-300' }}"></span>
                                            {{ $ws->name }}
                                        </button>
                                    </form>
                                @endforeach

                                <div class="border-t border-gray-100 mt-2 pt-2 px-3">
                                    <button @click="createOpen = true; workspaceOpen = false" type="button"
                                        class="w-full text-left text-sm font-medium text-violet-600 hover:text-violet-700 py-1">
                                        + Create workspace
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Create Workspace Modal -->
                        <div x-show="createOpen" x-transition
                            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/40" style="display: none;">
                            <div @click.outside="createOpen = false" class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-sm">
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">Create a workspace</h3>
                                <p class="text-sm text-gray-500 mb-4">Give your new workspace a name.</p>
                                <form method="POST" action="{{ route('workspaces.store') }}">
                                    @csrf
                                    <input type="text" name="name" required placeholder="e.g. Marketing Team"
                                        class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm mb-4" />
                                    <div class="flex justify-end gap-2">
                                        <button type="button" @click="createOpen = false"
                                            class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800">
                                            Cancel
                                        </button>
                                        <button type="submit"
                                            class="px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700 transition">
                                            Create
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('projects.index')" :active="request()->routeIs('projects.*')">
                        {{ __('Projects') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('projects.index')" :active="request()->routeIs('projects.*')">
                {{ __('Projects') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>