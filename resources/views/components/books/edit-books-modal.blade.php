<!-- Edit Book Modal -->
<div id="editBookModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"
        onclick="document.getElementById('editBookModal').classList.add('hidden')"></div>

    <!-- Modal Content -->
    <div class="relative bg-[#1a1a2e] border border-white/10 rounded-2xl shadow-2xl w-full max-w-lg mx-4 p-6 animate-fade-in">
        <!-- Close Button -->
        <button type="button" onclick="document.getElementById('editBookModal').classList.add('hidden')"
            class="absolute top-4 right-4 text-gray-400 hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Header -->
        <h2 class="text-xl font-bold text-white mb-1">Edit Book</h2>
        <p class="text-gray-400 text-sm mb-6">Update book information below.</p>

        <!-- Form -->
        <form id="editBookForm" action="" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Title</label>
                    <input type="text" name="title" id="edit_book_title"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all">
                </div>

                <!-- ISBN -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">ISBN</label>
                    <input type="text" name="isbn" id="edit_book_isbn"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all">
                </div>

                <!-- Year Published -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Year Published</label>
                    <input type="number" name="year_published" id="edit_book_year_published" min="1500" max="{{ date('Y') }}"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all">
                </div>

                <!-- Total Copies -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Total Copies</label>
                    <input type="number" name="total_copies" id="edit_book_total_copies" min="1"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all">
                </div>

                <!-- Available Copies -->
                <!-- <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Available Copies</label>
                    <input type="number" name="available_copies" id="edit_book_available_copies" min="0"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all">
                </div> -->

                <!-- Authors -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Authors</label>

                    <select name="authors[]" id="edit_book_authors" multiple
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all">
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}" class="bg-[#1a1a2e] text-white">
                                {{ $author->name }}
                            </option>
                        @endforeach
                    </select>

                    <p class="text-xs text-gray-400 mt-1">
                        Hold CTRL (Windows) or CMD (Mac) to select multiple authors.
                    </p>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-2">
                <button type="button" onclick="document.getElementById('editBookModal').classList.add('hidden')"
                    class="px-5 py-2.5 rounded-xl text-sm font-medium text-gray-300 hover:text-white hover:bg-white/5 transition-all">
                    Cancel
                </button>

                <button type="submit"
                    class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold transition-all hover:shadow-lg hover:shadow-indigo-500/30">
                    Update Book
                </button>
            </div>
        </form>
    </div>
</div>