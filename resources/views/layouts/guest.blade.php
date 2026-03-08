<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#0b0f1e] font-sans text-white antialiased">
        <div aria-hidden="true"
            class="pointer-events-none absolute -top-32 -right-24 h-[420px] w-[420px] rounded-full bg-indigo-500/20 blur-3xl">
        </div>
        <div aria-hidden="true"
            class="pointer-events-none absolute -bottom-32 -left-24 h-[460px] w-[460px] rounded-full bg-cyan-400/10 blur-3xl">
        </div>
        <div aria-hidden="true"
            class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_1px_1px,rgba(255,255,255,0.04)_1px,transparent_0)] [background-size:22px_22px]">
        </div>

        <div class="relative z-10 flex min-h-screen flex-col items-center justify-center px-6 py-10 overflow-auto">
            <a href="/" class="mb-8 flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-500/20 text-indigo-300">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-[0.25em] text-indigo-200/70">Mini Library</p>
                    <p class="text-lg font-semibold">{{ config('app.name', 'Mini Library System') }}</p>
                </div>
            </a>

            <div class="w-full max-w-md rounded-3xl px-8 py-8 glass-card animate-fade-in">
                {{ $slot }}
            </div>

            <p class="mt-6 text-xs text-gray-500">
                &copy; {{ date('Y') }} {{ config('app.name', 'Mini Library System') }}. All rights reserved.
            </p>
        </div>
    </body>
</html>
