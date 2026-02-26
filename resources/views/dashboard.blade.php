<x-layouts.layout title="Dashboard" activePage="dashboard">
    <x-slot:header>
        @include('components.header-sections.headers')
    </x-slot:header>
    <!-- Page Heading -->
    <div class="mb-6 animate-fade-in">
        <h1 class="text-2xl font-bold text-white">Dashboard Overview</h1>
        <p class="text-gray-400 text-sm mt-1">Welcome back! Here's what's happening today.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Total Students -->
        <div class="stat-card-gradient-1 rounded-2xl p-5 card-hover animate-fade-in relative overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2">
            </div>
            <div class="flex items-start justify-between relative z-10">
                <div>
                    <p class="text-white/70 text-xs font-medium mb-1">Total Students</p>
                    <h3 class="text-3xl font-bold text-white">{{ $totalStudents }}</h3>
                    <p class="text-emerald-300 text-xs font-medium mt-2 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        
                    </p>
                </div>
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Active Classes -->
        <div class="stat-card-gradient-2 rounded-2xl p-5 card-hover animate-fade-in relative overflow-hidden"
            style="animation-delay: 0.1s">
            <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2">
            </div>
            <div class="flex items-start justify-between relative z-10">
                <div>
                    <p class="text-white/70 text-xs font-medium mb-1">Books</p>
                    <h3 class="text-3xl font-bold text-white">{{ $totalBooks }}</h3>
                    <p class="text-white/60 text-xs font-medium mt-2"></p>
                </div>
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pending Enrollments -->
        <div class="stat-card-gradient-3 rounded-2xl p-5 card-hover animate-fade-in relative overflow-hidden"
            style="animation-delay: 0.2s">
            <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2">
            </div>
            <div class="flex items-start justify-between relative z-10">
                <div>
                    <p class="text-white/70 text-xs font-medium mb-1">Authors</p>
                    <h3 class="text-3xl font-bold text-white">{{ $totalAuthors }}</h3>
                    <p class="text-white/60 text-xs font-medium mt-2"></p>
                </div>
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Faculty Count -->
        <div class="stat-card-gradient-4 rounded-2xl p-5 card-hover animate-fade-in relative overflow-hidden"
            style="animation-delay: 0.3s">
            <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2">
            </div>
            <div class="flex items-start justify-between relative z-10">
                <div>
                    <p class="text-white/70 text-xs font-medium mb-1">Borrowed Books</p>
                    <h3 class="text-3xl font-bold text-white">{{ $totalBorrows }}</h3>
                    <p class="text-emerald-300 text-xs font-medium mt-2 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        
                    </p>
                </div>
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Grid: Recent Activity + Quick Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 animate-fade-in" style="animation-delay: 0.4s">

        <!-- Recent Activity -->
        <div class="lg:col-span-2 glass-card rounded-2xl p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-bold text-white">Borrowed books</h2>
                <a href="{{ route('borrows.index') }}"
                    class="text-indigo-400 hover:text-indigo-300 text-sm font-medium transition-colors">View All</a>
            </div>

                                    <div class="space-y-3">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-white/10">
                                <th class="text-left py-3 px-4 text-xs font-semibold text-indigo-400 uppercase tracking-wider">
                                    Student</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-indigo-400 uppercase tracking-wider">
                                    Books</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-indigo-400 uppercase tracking-wider">
                                    Borrow Date</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-indigo-400 uppercase tracking-wider">
                                    Due Date</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-indigo-400 uppercase tracking-wider">
                                    Total Fine</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-indigo-400 uppercase tracking-wider">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @forelse ($recentBorrows as $recentBorrow)
                                @php
                                    $isReturned = $recentBorrow->returned_at !== null;
                                    $student = $recentBorrow->student;
                                    $studentInitial = $student?->first_name
                                        ? strtoupper(substr($student->first_name, 0, 1))
                                        : 'N';
                                @endphp
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="py-3.5 px-4 flex items-center space-x-3 text-sm text-white">
                                        <div
                                            class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center">
                                            <span class="text-white font-bold text-sm">{{ $studentInitial }}</span>
                                        </div>
                                        <div>
                                            <p>{{ $student?->first_name }} {{ $student?->last_name }}</p>
                                            <p class="text-gray-400 text-xs">{{ $student?->course ?? '—' }}</p>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4 text-sm text-white">
                                        @forelse ($recentBorrow->items as $item)
                                            <p>{{ $item->book?->title ?? 'Unknown Book' }}</p>
                                        @empty
                                            <p class="text-gray-400">No items</p>
                                        @endforelse
                                    </td>
                                    <td class="py-3.5 px-4 text-sm text-white">{{ $recentBorrow->borrow_date }}</td>
                                    <td class="py-3.5 px-4 text-sm text-white">{{ $recentBorrow->due_date }}</td>
                                    <td class="py-3.5 px-4 text-sm text-white">&#8369;{{ number_format($recentBorrow->current_fine, 2) }}</td>
                                    <td class="py-3.5 px-4 text-sm">
                                        @if ($isReturned)
                                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/15 text-emerald-300">
                                                Returned
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-500/15 text-yellow-300">
                                                Borrowed
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-6 text-center text-sm text-gray-400">
                                        No recent borrow records.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
<div class="glass-card rounded-2xl p-6">
    <h2 class="text-lg font-bold text-white mb-5">Quick Stats</h2>

    <!-- Library Year -->
    <div class="mb-6">
        <div class="flex items-center space-x-3 mb-1">
            <div class="w-8 h-8 bg-indigo-500/20 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <p class="text-gray-400 text-xs">Library Year</p>
                <p class="text-white font-bold text-lg">2025–2026</p>
            </div>
        </div>
    </div>

    <!-- Book Availability Progress -->
    <div class="mb-6">
        <div class="flex justify-between items-center mb-2">
            <p class="text-gray-400 text-xs font-medium">Book Availability</p>
            <span class="text-indigo-400 text-xs font-semibold">{{ $availabilityPercent ?? 0 }}%</span>
        </div>

        <div class="w-full bg-white/10 rounded-full h-2.5">
            <div class="bg-gradient-to-r from-indigo-500 to-blue-500 h-2.5 rounded-full transition-all duration-1000"
                style="width: {{ $availabilityPercent ?? 0 }}%"></div>
        </div>

        <p class="text-gray-500 text-[10px] mt-1.5">
            Available {{ $availableCopies ?? 0 }} / {{ $totalCopies ?? 0 }} copies
        </p>
    </div>

    <!-- Divider -->
    <div class="border-t border-white/5 my-4"></div>

    <!-- Inventory Summary -->
    <div>
        <p class="text-gray-400 text-xs font-medium mb-3">Inventory Summary</p>

        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <div class="w-2 h-2 bg-indigo-500 rounded-full"></div>
                    <span class="text-gray-300 text-sm">Total Copies</span>
                </div>
                <span class="text-white font-bold text-sm">{{ $totalCopies ?? 0 }}</span>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                    <span class="text-gray-300 text-sm">Available Copies</span>
                </div>
                <span class="text-white font-bold text-sm">{{ $availableCopies ?? 0 }}</span>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <div class="w-2 h-2 bg-rose-500 rounded-full"></div>
                    <span class="text-gray-300 text-sm">Borrowed Copies</span>
                </div>
                <span class="text-white font-bold text-sm">{{ $borrowedCopies ?? 0 }}</span>
            </div>
        </div>
    </div>

    <!-- Divider -->
    <div class="border-t border-white/5 my-4"></div>

    <!-- Borrow Activity -->
    <div>
        <p class="text-gray-400 text-xs font-medium mb-3">Borrow Activity</p>

        <div class="flex space-x-2">
            <div class="flex-1 bg-indigo-500/20 rounded-xl p-3 text-center">
                <p class="text-indigo-400 text-lg font-bold">{{ $borrowsThisMonth ?? 0 }}</p>
                <p class="text-gray-400 text-[10px]">This Month</p>
            </div>

            <div class="flex-1 bg-amber-500/20 rounded-xl p-3 text-center">
                <p class="text-amber-400 text-lg font-bold">{{ $activeBorrows ?? 0 }}</p>
                <p class="text-gray-400 text-[10px]">Active</p>
            </div>
        </div>
    </div>
</div>

</x-layouts.layout>


