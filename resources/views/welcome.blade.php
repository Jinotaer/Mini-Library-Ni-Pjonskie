<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Mini Library System') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="relative min-h-screen overflow-hidden bg-[#0b0f1e] text-white">
    <div aria-hidden="true" class="pointer-events-none absolute -top-32 -right-32 h-[520px] w-[520px] rounded-full bg-indigo-500/20 blur-3xl"></div>
    <div aria-hidden="true" class="pointer-events-none absolute -bottom-40 -left-32 h-[560px] w-[560px] rounded-full bg-cyan-400/10 blur-3xl"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_1px_1px,rgba(255,255,255,0.04)_1px,transparent_0)] [background-size:24px_24px]"></div>

    <header class="relative z-10 border-b border-white/10 bg-white/5 backdrop-blur-xl">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-500/20 text-indigo-300">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-indigo-200/70">Library Management</p>
                    <h1 class="text-lg font-semibold">{{ config('app.name', 'Mini Library System') }}</h1>
                </div>
            </div>

            <nav class="flex items-center gap-3 text-sm font-semibold">
                @auth
                    <!-- <a href="{{ route('dashboard') }}" class="rounded-lg border border-white/10 bg-white/10 px-4 py-2 text-white transition hover:bg-white/20">
                        Dashboard
                    </a> -->
                @else
                    <a href="{{ route('login') }}" class="text-gray-300 transition hover:text-white">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="rounded-lg bg-indigo-500/80 px-4 py-2 text-white shadow-lg shadow-indigo-500/30 transition hover:bg-indigo-500">
                        Register
                    </a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="relative z-10">
        <div class="mx-auto grid max-w-6xl items-center gap-10 px-6 py-16 lg:grid-cols-2">
            <div class="space-y-6 animate-fade-in">
                <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs uppercase tracking-[0.25em] text-indigo-200/70">
                    Organized. Accurate. Fast.
                </div>
                <h2 class="text-4xl font-semibold leading-tight sm:text-5xl">
                    Borrow, track, and manage
                    <span class="block bg-gradient-to-r from-indigo-300 via-sky-300 to-emerald-200 bg-clip-text text-transparent">
                        your library in one place
                    </span>
                </h2>
                <p class="text-base leading-relaxed text-gray-300 sm:text-lg">
                    Keep your inventory clean, manage authors and books, and monitor borrowing in a clear, modern dashboard.
                    Built for speed and clarity so your team can focus on service, not spreadsheets.
                </p>

                <div class="flex flex-wrap gap-2 text-xs text-gray-300">
                    <span class="rounded-full bg-white/10 px-3 py-1">Inventory tracking</span>
                    <span class="rounded-full bg-white/10 px-3 py-1">Borrow management</span>
                    <span class="rounded-full bg-white/10 px-3 py-1">Fine computation</span>
                    <span class="rounded-full bg-white/10 px-3 py-1">Author catalog</span>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 rounded-xl bg-indigo-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-500/30 transition hover:bg-indigo-400">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-xl bg-indigo-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-500/30 transition hover:bg-indigo-400">
                            Get Started
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-xl border border-white/10 px-6 py-3 text-sm font-semibold text-gray-200 transition hover:bg-white/10">
                            Create Account
                        </a>
                    @endauth
                </div>
            </div>

            <div class="relative animate-fade-in" style="animation-delay: 0.1s">
                <div class="glass-card relative overflow-hidden rounded-3xl p-8">
                    <div class="absolute right-6 top-6 flex items-center gap-2 text-xs text-emerald-300">
                        <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                        Live status
                    </div>

                    <h3 class="text-lg font-semibold">Library Snapshot</h3>
                    <p class="mt-2 text-sm text-gray-300">A quick view of what your team manages daily.</p>

                    <div class="mt-6 space-y-4">
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                            <p class="text-xs uppercase text-gray-400">Borrow tracking</p>
                            <p class="mt-1 text-lg font-semibold">Active loans and fine alerts</p>
                            <div class="mt-3 h-2 w-full rounded-full bg-white/10">
                                <div class="h-2 w-2/3 rounded-full bg-gradient-to-r from-indigo-400 to-cyan-300"></div>
                            </div>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                            <p class="text-xs uppercase text-gray-400">Inventory balance</p>
                            <p class="mt-1 text-lg font-semibold">Availability at a glance</p>
                            <div class="mt-3 flex items-center gap-2 text-xs text-gray-300">
                                <span class="rounded-full bg-indigo-500/20 px-2 py-1 text-indigo-200">In stock</span>
                                <span class="rounded-full bg-amber-500/20 px-2 py-1 text-amber-200">Borrowed</span>
                                <span class="rounded-full bg-rose-500/20 px-2 py-1 text-rose-200">Overdue</span>
                            </div>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                            <p class="text-xs uppercase text-gray-400">Author network</p>
                            <p class="mt-1 text-lg font-semibold">Many-to-many catalog ready</p>
                            <p class="mt-2 text-xs text-gray-400">Attach multiple authors per title and keep records clean.</p>
                        </div>
                    </div>
                </div>

                <!-- <div class="absolute -bottom-6 -left-6 hidden rounded-3xl border border-white/10 bg-white/5 p-4 text-xs text-gray-300 shadow-xl shadow-black/40 lg:block">
                    <p class="font-semibold text-white">Secure access</p>
                    <p class="mt-1">Staff-only dashboard with Breeze auth.</p>
                </div> -->
            </div>
        </div>
    </main>

    <footer class="relative z-10 border-t border-white/10 bg-white/5 py-6 text-center text-xs text-gray-400">
        &copy; {{ date('Y') }} {{ config('app.name', 'Mini Library System') }}. All rights reserved.
    </footer>
</body>
</html>
