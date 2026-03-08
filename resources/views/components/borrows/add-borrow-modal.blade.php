<!-- Add Borrow Modal -->
<div id="addBorrowModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"
        onclick="document.getElementById('addBorrowModal').classList.add('hidden')"></div>

    <!-- Modal Content -->
    <div
        class="relative bg-[#1a1a2e] border border-white/10 rounded-2xl shadow-2xl w-full max-w-3xl mx-4 p-6 animate-fade-in">
        <!-- Close Button -->
        <button onclick="document.getElementById('addBorrowModal').classList.add('hidden')"
            class="absolute top-4 right-4 text-gray-400 hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Header -->
        <h2 class="text-xl font-bold text-white mb-1">Add Borrow Record</h2>
        <p class="text-gray-400 text-sm mb-6">Select a student, set dates, and add books.</p>

        <!-- Form -->
        <form id="addBorrowForm" action="{{ route('borrows.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="relative">
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Student</label>
                    <input type="text" id="add_borrow_student_search" placeholder="Type student name or ID to search"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all" autocomplete="off">
                    <input type="hidden" name="student_id" id="add_borrow_student_id" required>

                    <div id="addStudentDropdown" class="hidden absolute left-0 w-full mt-2 rounded-lg shadow-2xl"
                        style="background-color:#0b1220; border:1px solid rgba(255,255,255,0.06); max-height:240px; overflow-y:auto; z-index:9999; backdrop-filter:none; -webkit-backdrop-filter:none;">
                        <ul style="margin:0; padding:0; list-style:none;">
                            @foreach ($students as $student)
                                <li data-id="{{ $student->id }}" data-name="{{ $student->full_name }}" data-number="{{ $student->student_number }}"
                                    style="padding:12px 16px; cursor:pointer; background-color: #0b1220; color:#ffffff; border-bottom:1px solid rgba(255,255,255,0.04);">
                                    <div style="font-size:0.95rem; line-height:1.1">{{ $student->full_name }}</div>
                                    <div style="font-size:0.75rem; color:rgba(255,255,255,0.65); margin-top:4px">{{ $student->student_number }}</div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Borrow Date</label>
                    <input type="date" name="borrow_date" value="{{ date('Y-m-d') }}"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Due Date</label>
                    <input type="date" name="due_date" value="{{ date('Y-m-d', strtotime('+14 days')) }}"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Initial Fine (₱)</label>
                    <input type="number" name="total_fine" min="0" value="0" step="0.01"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all">
                </div>
            </div>

            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <label class="block text-sm font-medium text-gray-300">Books</label>
                    <button type="button" id="addBorrowBookRow"
                        class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-indigo-500/15 text-indigo-300 hover:bg-indigo-500/25 transition-all">
                        Add Book
                    </button>
                </div>

                <div id="borrowBookRows" class="space-y-2">
                    <div class="borrow-book-row flex flex-col md:flex-row gap-3 md:items-center">
                        <select name="books[0][book_id]"
                            class="flex-1 bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all">
                            @forelse ($availableBooks as $book)
                                <option value="{{ $book->id }}" class="bg-[#1a1a2e] text-white">
                                    {{ $book->title }} ({{ $book->available_copies }} available)
                                </option>
                            @empty
                                <option value="" class="bg-[#1a1a2e] text-white" disabled>No available books</option>
                            @endforelse
                        </select>

                        <input type="number" name="books[0][quantity]" min="1" value="1"
                            class="w-full md:w-32 bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all">

                        <button type="button"
                            class="removeBorrowBookRow px-3 py-2 rounded-lg text-sm text-gray-300 hover:text-white hover:bg-white/5 transition-all">
                            Remove
                        </button>
                    </div>
                </div>
            </div>

            <template id="borrowBookRowTemplate">
                <div class="borrow-book-row flex flex-col md:flex-row gap-3 md:items-center">
                    <select name="books[__INDEX__][book_id]"
                        class="flex-1 bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all">
                        @forelse ($availableBooks as $book)
                            <option value="{{ $book->id }}" class="bg-[#1a1a2e] text-white">
                                {{ $book->title }} ({{ $book->available_copies }} available)
                            </option>
                        @empty
                            <option value="" class="bg-[#1a1a2e] text-white" disabled>No available books</option>
                        @endforelse
                    </select>

                    <input type="number" name="books[__INDEX__][quantity]" min="1" value="1"
                        class="w-full md:w-32 bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all">

                    <button type="button"
                        class="removeBorrowBookRow px-3 py-2 rounded-lg text-sm text-gray-300 hover:text-white hover:bg-white/5 transition-all">
                        Remove
                    </button>
                </div>
            </template>

            <!-- Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-2">
                <button type="button"
                    onclick="document.getElementById('addBorrowModal').classList.add('hidden')"
                    class="px-5 py-2.5 rounded-xl text-sm font-medium text-gray-300 hover:text-white hover:bg-white/5 transition-all">
                    Cancel
                </button>
                <button type="submit"
                    class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold transition-all hover:shadow-lg hover:shadow-indigo-500/30">
                    Add Borrow
                </button>
            </div>
        </form>
    </div>
</div>
