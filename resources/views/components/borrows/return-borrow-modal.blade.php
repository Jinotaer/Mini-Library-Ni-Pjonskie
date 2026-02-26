<!-- Return Borrow Modal -->
<div id="returnBorrowModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"
        onclick="document.getElementById('returnBorrowModal').classList.add('hidden')"></div>

    <!-- Modal Content -->
    <div
        class="relative bg-[#1a1a2e] border border-white/10 rounded-2xl shadow-2xl w-full max-w-lg mx-4 p-6 animate-fade-in">
        <!-- Close Button -->
        <button onclick="document.getElementById('returnBorrowModal').classList.add('hidden')"
            class="absolute top-4 right-4 text-gray-400 hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Header -->
        <h2 class="text-xl font-bold text-white mb-1">Return Borrowed Book</h2>
        <p class="text-gray-400 text-sm mb-6">Select a book and quantity to return.</p>

        <!-- Form -->
        <form id="returnBorrowForm" action="" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Book</label>
                <select id="returnBorrowItemSelect"
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/40 transition-all">
                </select>
                <p id="returnBorrowRemaining" class="text-xs text-gray-400 mt-1"></p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Return Quantity</label>
                <input type="number" name="return_quantity" id="returnBorrowQuantity" min="1" value="1"
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/40 transition-all">
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-2">
                <button type="button"
                    onclick="document.getElementById('returnBorrowModal').classList.add('hidden')"
                    class="px-5 py-2.5 rounded-xl text-sm font-medium text-gray-300 hover:text-white hover:bg-white/5 transition-all">
                    Cancel
                </button>
                <button type="button" id="returnAllBorrowBtn"
                    class="px-5 py-2.5 bg-white/5 text-white rounded-xl text-sm font-semibold transition-all hover:bg-white/10">
                    Return All
                </button>
                <button type="submit"
                    class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-semibold transition-all hover:shadow-lg hover:shadow-emerald-500/30">
                    Return Selected
                </button>
            </div>
        </form>

        <form id="returnAllBorrowForm" action="" method="POST" class="hidden">
            @csrf
        </form>
    </div>
</div>
