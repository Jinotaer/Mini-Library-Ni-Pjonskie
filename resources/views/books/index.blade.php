<x-layouts.layout title="Book Management" activePage="books">
    <x-slot:header>
        @include('components.header-sections.headers')
    </x-slot:header>
    <!-- Page Heading -->
    <div class="flex items-center justify-between mb-6 animate-fade-in">
        <div>
            <h1 class="text-2xl font-bold text-white">Book Inventory</h1>
            <p class="text-gray-400 text-sm mt-1">Manage book records and availability</p>
        </div>
        <button onclick="document.getElementById('addBookModal').classList.remove('hidden')"
            class="flex items-center space-x-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition-all hover:shadow-lg hover:shadow-indigo-500/30 transform hover:-translate-y-0.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Add Book</span>
        </button>
    </div>

    <!-- Table Card -->
    <div class="glass-card rounded-2xl p-6 animate-fade-in" style="animation-delay: 0.1s">

        <!-- Search Bar -->
        <div class="mb-5">
            <form method="GET" action="{{ route('books.index') }}" class="relative max-w-md"
                data-auto-search="true">
                <svg class="w-4 h-4 text-gray-500 absolute left-3 top-1/2 -translate-y-1/2" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search by title, ISBN, or author"
                    class="w-full bg-white/5 border border-white/10 rounded-xl pl-10 pr-16 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all">
                <div class="absolute right-2 top-1/2 -translate-y-1/2 flex items-center gap-1">
                    @if (request()->filled('search'))
                        <a href="{{ route('books.index') }}"
                            class="px-2 py-1 text-xs text-gray-300 hover:text-white transition-colors">Clear</a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/10">
                        <th class="text-left py-3 px-4 text-xs font-semibold text-indigo-400 uppercase tracking-wider">
                            Book</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-indigo-400 uppercase tracking-wider">
                            ISBN</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-indigo-400 uppercase tracking-wider">
                            Authors</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-indigo-400 uppercase tracking-wider">
                            Total Copies</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-indigo-400 uppercase tracking-wider">
                            Available Copies</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-indigo-400 uppercase tracking-wider">
                            Year Published</th>
                        <th class="text-right py-3 px-4 text-xs font-semibold text-indigo-400 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach ($books as $index => $book)
                        @php
                            $authorNames = '';
                            $authorIds = [];
                            if ($book->relationLoaded('authors')) {
                                $authorRelation = $book->getRelation('authors');
                                $authorNames = $authorRelation->pluck('name')->filter()->join(', ');
                                $authorIds = $authorRelation->pluck('id')->values()->all();
                            }
                            if ($authorNames === '' && is_string($book->authors)) {
                                $authorNames = $book->authors;
                            }
                        @endphp
                        <tr class="hover:bg-white/5 transition-colors group animate-slide-in"
                            style="animation-delay: {{ 0.15 + $index * 0.05 }}s; opacity: 0;">
                            <td class="py-3.5 px-4">
                                <span class="text-gray-400 text-sm font-mono">{{ $book->title }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="text-white text-sm font-medium">{{ $book->isbn }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="text-white text-sm font-medium">{{ $authorNames !== '' ? $authorNames : '-' }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="text-white text-sm font-medium">{{ $book->total_copies }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="text-white text-sm font-medium">{{ $book->available_copies }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="text-white text-sm font-medium">{{ $book->year_published }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex items-center justify-end space-x-2">
                                    <!-- Edit Button -->
                                    <button type="button" data-update-url="{{ route('books.update', $book) }}"
                                        data-book-title="{{ $book->title }}"
                                        data-book-isbn="{{ $book->isbn }}"
                                        data-book-authors="{{ $authorNames }}"
                                        data-book-author-ids='@json($authorIds)'
                                        data-book-total-copies="{{ $book->total_copies }}"
                                        data-book-year-published="{{ $book->year_published }}"
                                        onclick="openEditModal(this)"
                                        class="p-2 rounded-lg bg-indigo-500/10 text-indigo-400 hover:bg-indigo-500/20 hover:text-indigo-300 transition-all"
                                        title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <!-- Delete Button -->
                                    <button type="button" data-delete-url="{{ route('books.destroy', $book) }}"
                                        data-book-title="{{ $book->title }}" onclick="openDeleteModal(this)"
                                        class="p-2 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 hover:text-red-300 transition-all"
                                        title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('components.books.add-books-modal')
    @include('components.books.edit-books-modal')
    @include('components.books.delete-books-modal')

    <script>
        // --- Open Edit Modal ---
        function openEditModal(button) {
            const form = document.getElementById('editBookForm');
            form.action = button.dataset.updateUrl;
            document.getElementById('edit_book_title').value = button.dataset.bookTitle ?? '';
            document.getElementById('edit_book_isbn').value = button.dataset.bookIsbn ?? '';
            document.getElementById('edit_book_total_copies').value = button.dataset.bookTotalCopies ?? '';
            document.getElementById('edit_book_year_published').value = button.dataset.bookYearPublished ?? '';

            const authorIds = JSON.parse(button.dataset.bookAuthorIds ?? '[]');
            const authorCheckboxes = document.querySelectorAll('#editBookModal .edit-book-author-checkbox');
            if (authorCheckboxes.length > 0) {
                authorCheckboxes.forEach((checkbox) => {
                    checkbox.checked = authorIds.includes(Number(checkbox.value));
                });
            }
            document.getElementById('editBookModal').classList.remove('hidden');
            showToast('Editing book: ' + (button.dataset.bookTitle ?? ''), 'info');
        }

        function openDeleteModal(button) {
            const modal = document.getElementById('deleteConfirmModal');
            const nameEl = document.getElementById('deleteBookName');
            const form = document.getElementById('deleteBookForm');
            const bookName = button?.dataset?.bookTitle ?? '';
            const deleteUrl = button?.dataset?.deleteUrl ?? '';

            if (nameEl) {
                nameEl.textContent = bookName;
            }

            if (form) {
                form.action = deleteUrl;
            }

            if (modal) {
                modal.classList.remove('hidden');
            }
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteConfirmModal');
            if (modal) {
                modal.classList.add('hidden');
            }
        }
    </script>

</x-layouts.layout>
