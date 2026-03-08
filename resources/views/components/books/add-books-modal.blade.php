<!-- Add Book Modal -->
<div id="addBookModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"
        onclick="document.getElementById('addBookModal').classList.add('hidden')"></div>

    <!-- Modal Content -->
    <div class="relative bg-[#1a1a2e] border border-white/10 rounded-2xl shadow-2xl w-full max-w-lg mx-4 p-6 animate-fade-in">
        <!-- Close Button -->
        <button type="button" onclick="document.getElementById('addBookModal').classList.add('hidden')"
            class="absolute top-4 right-4 text-gray-400 hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Header -->
        <h2 class="text-xl font-bold text-white mb-1">Add New Book</h2>
        <p class="text-gray-400 text-sm mb-6">Enter book information to add a new record.</p>

        <!-- Form -->
        <form action="{{ route('books.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" placeholder="e.g. The Great Gatsby"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all">
                </div>

                <!-- ISBN -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">ISBN</label>
                    <input type="text" name="isbn" value="{{ old('isbn') }}" placeholder="e.g. 978-0-7432-7356-5"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all">
                </div>

                <!-- Year Published -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Year Published</label>
                    <input type="number" name="year_published" value="{{ old('year_published') }}" min="1500" max="{{ date('Y') }}"
                        placeholder="e.g. 1925"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all">
                </div>

                <!-- Total Copies -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Total Copies</label>
                    <input type="number" name="total_copies" value="{{ old('total_copies', 1) }}" min="1"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all">
                </div>

                <!-- Available Copies -->
                <!-- <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Available Copies</label>
                    <input type="number" name="available_copies" value="{{ old('available_copies', 1) }}" min="0"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all">
                    <p class="text-xs text-gray-400 mt-1">
                        Tip: Usually set Available Copies = Total Copies (unless some are missing/damaged).
                    </p>
                </div> -->

                <!-- Authors (Many-to-Many) -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Authors</label>

                    <div class="author-checklist custom-scrollbar">
                        @foreach($authors as $author)
                            <label class="author-checklist-item">
                                <input type="checkbox" name="authors[]" value="{{ $author->id }}"
                                    @checked(collect(old('authors', []))->contains($author->id))>
                                <span>{{ $author->name }}</span>
                            </label>
                        @endforeach
                    </div>

                    <p class="text-xs text-gray-400 mt-1">
                        Select one or more authors.
                    </p>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-2">
                <button type="button" onclick="document.getElementById('addBookModal').classList.add('hidden')"
                    class="px-5 py-2.5 rounded-xl text-sm font-medium text-gray-300 hover:text-white hover:bg-white/5 transition-all">
                    Cancel
                </button>

                <button type="submit"
                    class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold transition-all hover:shadow-lg hover:shadow-indigo-500/30">
                    Add Book
                </button>
            </div>
        </form>
    </div>
</div>
