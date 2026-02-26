<!-- Edit Borrow Modal -->
<div id="editBorrowModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"
        onclick="document.getElementById('editBorrowModal').classList.add('hidden')"></div>

    <!-- Modal Content -->
    <div
        class="relative bg-[#1a1a2e] border border-white/10 rounded-2xl shadow-2xl w-full max-w-3xl mx-4 p-6 animate-fade-in">
        <!-- Close Button -->
        <button onclick="document.getElementById('editBorrowModal').classList.add('hidden')"
            class="absolute top-4 right-4 text-gray-400 hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Header -->
        <h2 class="text-xl font-bold text-white mb-1">Edit Borrow Record</h2>
        <p class="text-gray-400 text-sm mb-6">Update the due date and books for this borrow.</p>

        <!-- Form -->
        <form id="editBorrowForm" action="" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Student</label>
                    <input type="text" id="edit_borrow_student" readonly
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white opacity-80 cursor-not-allowed">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Borrow Date</label>
                    <input type="date" id="edit_borrow_date" readonly
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white opacity-80 cursor-not-allowed">
                </div>

                <input type="hidden" name="borrow_date" id="edit_borrow_date_hidden">

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Due Date</label>
                    <input type="date" name="due_date" id="edit_borrow_due_date"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all">
                </div>
            </div>

            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <label class="block text-sm font-medium text-gray-300">Books</label>
                    <button type="button" id="editBorrowAddRow"
                        class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-indigo-500/15 text-indigo-300 hover:bg-indigo-500/25 transition-all">
                        Add Book
                    </button>
                </div>

                <div id="editBorrowBookRows" class="space-y-2"></div>
            </div>

            <template id="editBorrowBookRowTemplate">
                <div class="borrow-book-row flex flex-col md:flex-row gap-3 md:items-center">
                    <select name="books[__INDEX__][book_id]"
                        class="flex-1 bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all">
                        @forelse ($books as $book)
                            <option value="{{ $book->id }}" class="bg-[#1a1a2e] text-white">
                                {{ $book->title }} ({{ $book->available_copies }} available)
                            </option>
                        @empty
                            <option value="" class="bg-[#1a1a2e] text-white" disabled>No books found</option>
                        @endforelse
                    </select>

                    <input type="number" name="books[__INDEX__][quantity]" min="1" value="1"
                        class="w-full md:w-32 bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all">

                    <button type="button"
                        class="removeEditBorrowBookRow px-3 py-2 rounded-lg text-sm text-gray-300 hover:text-white hover:bg-white/5 transition-all">
                        Remove
                    </button>
                </div>
            </template>

            <!-- Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-2">
                <button type="button"
                    onclick="document.getElementById('editBorrowModal').classList.add('hidden')"
                    class="px-5 py-2.5 rounded-xl text-sm font-medium text-gray-300 hover:text-white hover:bg-white/5 transition-all">
                    Cancel
                </button>
                <button type="submit"
                    class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold transition-all hover:shadow-lg hover:shadow-indigo-500/30">
                    Update Borrow
                </button>
            </div>
        </form>
    </div>
</div>
