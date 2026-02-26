<!-- Header -->
<header class="bg-[#0f0f23] h-20 flex items-center justify-between px-8 border-b border-white/5">
    <div class="flex-1 max-w-md">
        <div class="relative">
            <svg class="w-4 h-4 text-gray-500 absolute left-3 top-1/2 -translate-y-1/2" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" placeholder="Search students, classes..."
                class="w-full bg-white/5 border border-white/10 rounded-xl pl-10 pr-4 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all">
        </div>
    </div>
    <div class="flex items-center space-x-4">
        <!-- Notification Bell -->
        <div class="relative">
            <button onclick="document.getElementById('notifDropdown').classList.toggle('hidden')"
                class="relative p-2 text-gray-400 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                @if (($overdueCount ?? 0) > 0)
                    <span
                        class="absolute -top-1 -right-1 min-w-[18px] h-[18px] px-1 rounded-full bg-red-500 text-[10px] font-semibold text-white flex items-center justify-center">
                        {{ $overdueCount }}
                    </span>
                @endif
            </button>

            <!-- Notification Dropdown -->
            <div id="notifDropdown"
                class="hidden absolute right-0 top-full mt-2 w-80 bg-[#1a1a2e] border border-white/10 rounded-2xl shadow-2xl z-50 overflow-hidden">
                <!-- Header -->
                <div class="flex items-center justify-between px-4 py-3 border-b border-white/5">
                    <h3 class="text-sm font-bold text-white">Overdue Borrow Alerts</h3>
                    <span class="text-xs text-gray-400">{{ $overdueCount ?? 0 }} total</span>
                </div>

                <!-- Notification Items -->
                <div class="max-h-72 overflow-y-auto custom-scrollbar">
                    @forelse ($overdueBorrows ?? [] as $borrow)
                        @php
                            $studentName = $borrow->student?->full_name ?? 'Unknown Student';
                            $daysOverdue = \Illuminate\Support\Carbon::parse($borrow->due_date)->diffInDays(now());
                            $remainingBooks = $borrow->items->sum(fn ($item) => max($item->quantity - $item->returned_quantity, 0));
                        @endphp
                        <div
                            class="px-4 py-3 hover:bg-white/5 transition-colors border-l-2 border-red-500 cursor-pointer">
                            <div class="flex items-start space-x-3">
                                <div
                                    class="w-8 h-8 bg-red-500/20 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-red-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-white font-medium">{{ $studentName }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">
                                        Due {{ \Illuminate\Support\Carbon::parse($borrow->due_date)->format('M d, Y') }}
                                        • {{ $daysOverdue }} day{{ $daysOverdue === 1 ? '' : 's' }} overdue
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $remainingBooks }} book{{ $remainingBooks === 1 ? '' : 's' }} remaining •
                                        Fine: &#8369;{{ number_format($borrow->current_fine, 2) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-4 py-6 text-center text-sm text-gray-400">
                            No overdue borrows right now.
                        </div>
                    @endforelse
                </div>

                <!-- Footer -->
                <div class="px-4 py-3 border-t border-white/5 text-center">
                    <a href="{{ route('borrows.index') }}"
                        class="text-xs text-indigo-400 hover:text-indigo-300 font-medium transition-colors">View
                        All Borrows</a>
                </div>
            </div>
        </div>
        <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 hover:opacity-80 transition-opacity">
            <div class="text-right">
                <span class="font-semibold text-white block text-sm">{{ auth()->user()->name }}</span>
                <span class="text-xs text-gray-400">{{ auth()->user()->email }}</span>
            </div>
            <div
                class="w-9 h-9 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full shadow-lg flex items-center justify-center">
                <span class="text-white font-bold text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
            </div>
        </a>
    </div>
</header>
