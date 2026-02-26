<!---- name=resources/views/layouts/app.blade.php ---->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', config('app.name', 'Laravel'))</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body :class="{ 'overflow-hidden': sidebarOpen }" class="font-sans antialiased bg-gray-50 text-gray-900" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen flex">
        <!-- Mobile overlay (shows when sidebar open) -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-30 sm:hidden"></div>

        <!-- Fixed sidebar (offcanvas on mobile) -->
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full sm:translate-x-0'" class="fixed inset-y-0 left-0 w-64 transform transition-transform z-40 overflow-hidden">
            @include('layouts.navigation')
        </div>

        <!-- Mobile nav bar -->
        <div class="sm:hidden w-full bg-white border-b">
            <div class="flex items-center justify-between px-4 py-3">
                <a href="{{ route('dashboard') }}" class="text-lg font-semibold">{{ config('app.name', 'Library') }}</a>
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = true" class="p-2 rounded-md text-gray-600">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12h18M3 6h18M3 18h18"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Main content area -->
        <div class="flex-1 ml-0 sm:ml-64">
            <!-- header (section) -->
            @if(isset($header) || View::hasSection('header'))
                <div class="bg-white border-b">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="py-4">
                            @isset($header)
                                {{ $header }}
                            @else
                                @yield('header')
                            @endisset
                        </div>
                    </div>
                </div>
            @endif

            <main class="py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    @isset($slot)
                        {{ $slot }}
                    @endisset

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>