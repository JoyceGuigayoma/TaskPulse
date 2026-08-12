<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TaskPulse</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">

    <div class="min-h-screen flex flex-col justify-between">
        
        <!-- Navigation Header -->
        <header class="w-full max-w-7xl mx-auto px-6 py-6 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="h-10 w-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-bold text-xl shadow-md">
                    T
                </div>
                <span class="text-xl font-bold text-gray-900 tracking-tight">TaskPulse</span>
            </div>

            @if (Route::has('login'))
                <nav class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 rounded-lg bg-indigo-600 text-white font-medium hover:bg-indigo-700 transition shadow-sm">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-gray-600 font-medium hover:text-gray-900 transition">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-lg bg-indigo-600 text-white font-medium hover:bg-indigo-700 transition shadow-sm">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <!-- Main Hero Section -->
        <main class="max-w-4xl mx-auto px-6 text-center my-auto py-12">
            <span class="px-4 py-1.5 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700 tracking-wide uppercase">
                System Active & Running
            </span>
            
            <h1 class="mt-6 text-5xl font-extrabold text-gray-900 sm:text-6xl tracking-tight leading-tight">
                Welcome to <span class="text-indigo-600">TaskPulse</span>
            </h1>
            
            <p class="mt-4 text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Your application environment and services are up and running smoothly.
            </p>

            <div class="mt-8 flex justify-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-8 py-3.5 rounded-xl bg-indigo-600 text-white font-semibold shadow-lg hover:bg-indigo-700 transition">
                        Access Dashboard →
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-8 py-3.5 rounded-xl bg-indigo-600 text-white font-semibold shadow-lg hover:bg-indigo-700 transition">
                        Get Started
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-8 py-3.5 rounded-xl bg-white border border-gray-300 text-gray-700 font-semibold shadow-sm hover:bg-gray-50 transition">
                            Create Account
                        </a>
                    @endif
                @endauth
            </div>
        </main>

        <!-- Footer -->
        <footer class="w-full max-w-7xl mx-auto px-6 py-6 text-center text-sm text-gray-500">
            TaskPulse Project &copy; {{ date('Y') }}
        </footer>

    </div>

</body>
</html>