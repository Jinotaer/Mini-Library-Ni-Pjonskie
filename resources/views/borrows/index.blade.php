<x-layouts.layout title="Borrow Management" activePage="borrows">
    <x-slot:header>
        @include('components.header-sections.headers')
    </x-slot:header>

    <div class="flex items-center justify-between mb-6 animate-fade-in">
        <div>
            <h1 class="text-2xl font-bold text-white">Borrow Management</h1>
            <p class="text-gray-400 text-sm mt-1">Manage borrow records and transactions</p>
        </div>
        <button id="addBorrowBtn"
            class="flex items-center space-x-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition-all hover:shadow-lg hover:shadow-indigo-500/30 transform hover:-translate-y-0.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Add Borrow</span>
        </button>
    </div>

    <div class="glass-card rounded-2xl p-6 animate-fade-in" style="animation-delay: 0.1s">
        <div class="mb-5">
            <form method="GET" action="{{ route('borrows.index') }}" class="relative max-w-md"
                data-auto-search="true">
                <svg class="w-4 h-4 text-gray-500 absolute left-3 top-1/2 -translate-y-1/2" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search by student or book title..."
                    class="w-full bg-white/5 border border-white/10 rounded-xl pl-10 pr-16 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all">
                <div class="absolute right-2 top-1/2 -translate-y-1/2 flex items-center gap-1">
                    @if (request()->filled('search'))
                        <a href="{{ route('borrows.index') }}"
                            class="px-2 py-1 text-xs text-gray-300 hover:text-white transition-colors">Clear</a>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
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
                        <th class="text-left py-3 px-4 text-xs font-semibold text-indigo-400 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse ($borrows as $borrow)
                        @php
                            $studentName = $borrow->student?->full_name ?? 'Unknown Student';
                            $isReturned = ! is_null($borrow->returned_at);
                            $isOverdue = ! $isReturned && now()->greaterThan($borrow->due_date);
                            $borrowItems = $borrow->items->map(function ($item) {
                                return [
                                    'book_id' => $item->book_id,
                                    'quantity' => $item->quantity,
                                ];
                            })->values();
                            $borrowDate = \Illuminate\Support\Carbon::parse($borrow->borrow_date)->toDateString();
                            $dueDate = \Illuminate\Support\Carbon::parse($borrow->due_date)->toDateString();
                            $hasReturns = $borrow->items->where('returned_quantity', '>', 0)->isNotEmpty();
                            $canEdit = ! $isReturned && ! $hasReturns;
                            $returnItems = $borrow->items
                                ->map(function ($item) {
                                    $remaining = $item->quantity - $item->returned_quantity;
                                    if ($remaining <= 0) {
                                        return null;
                                    }

                                    return [
                                        'title' => $item->book?->title ?? 'Unknown Book',
                                        'remaining' => $remaining,
                                        'return_url' => route('borrows.return-item', $item),
                                    ];
                                })
                                ->filter()
                                ->values();
                        @endphp
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="py-3.5 px-4">
                                <div class="text-white text-sm font-medium">{{ $studentName }}</div>
                                <div class="text-gray-400 text-xs">{{ $borrow->student?->student_number }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-sm text-white">
                                @foreach ($borrow->items as $item)
                                    <div>
                                        {{ $item->book?->title ?? 'Unknown Book' }}
                                        <span class="text-gray-400">({{ $item->quantity }})</span>
                                    </div>
                                @endforeach
                            </td>
                            <td class="py-3.5 px-4 text-sm text-white">{{ $borrow->borrow_date }}</td>
                            <td class="py-3.5 px-4 text-sm text-white">{{ $borrow->due_date }}</td>
                            <td class="py-3.5 px-4 text-sm text-white">₱{{ number_format($borrow->current_fine, 2) }}</td>
                            <td class="py-3.5 px-4 text-sm">
                                @if ($isReturned)
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/15 text-emerald-300">
                                        Returned
                                    </span>
                                @elseif ($isOverdue)
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-red-500/15 text-red-300">
                                        Overdue
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-500/15 text-indigo-300">
                                        Borrowed
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-sm">
                                @if (! $isReturned)
                                    <div class="flex items-center gap-2">
                                        @if ($canEdit)
                                            <button type="button"
                                                data-update-url="{{ route('borrows.update', $borrow) }}"
                                                data-student-name="{{ $studentName }}"
                                                data-student-number="{{ $borrow->student?->student_number }}"
                                                data-borrow-date="{{ $borrowDate }}"
                                                data-due-date="{{ $dueDate }}"
                                                data-borrow-items='@json($borrowItems)'
                                                onclick="openEditBorrowModal(this)"
                                                class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-indigo-500/15 text-indigo-300 hover:bg-indigo-500/25 transition-all">
                                                Edit
                                            </button>
                                        @endif
                                        @if ($returnItems->isNotEmpty())
                                            <button type="button"
                                                data-return-items='@json($returnItems)'
                                                data-return-all-url="{{ route('borrows.return-all', $borrow) }}"
                                                onclick="openReturnBorrowModal(this)"
                                                class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-emerald-500/15 text-emerald-300 hover:bg-emerald-500/25 transition-all">
                                                Return
                                            </button>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-xs text-gray-500">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-6 text-center text-sm text-gray-400">
                                No borrow records yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $borrows->links() }}
        </div>
    </div>

    @include('components.borrows.add-borrow-modal')
    @include('components.borrows.edit-borrow-modal')
    @include('components.borrows.return-borrow-modal')

    <script>
        const addBorrowBtn = document.getElementById('addBorrowBtn');
        const addBorrowModal = document.getElementById('addBorrowModal');
        const addBorrowBookRow = document.getElementById('addBorrowBookRow');
        const borrowBookRows = document.getElementById('borrowBookRows');
        const borrowBookRowTemplate = document.getElementById('borrowBookRowTemplate');

        if (addBorrowBtn && addBorrowModal) {
            addBorrowBtn.addEventListener('click', () => {
                // reset student search fields when opening modal
                const studentSearch = document.getElementById('add_borrow_student_search');
                const studentHidden = document.getElementById('add_borrow_student_id');
                const studentDropdown = document.getElementById('addStudentDropdown');
                if (studentSearch) studentSearch.value = '';
                if (studentHidden) studentHidden.value = '';
                if (studentDropdown) studentDropdown.classList.add('hidden');

                addBorrowModal.classList.remove('hidden');
            });
        }

        const editBorrowAddRow = document.getElementById('editBorrowAddRow');
        const editBorrowBookRows = document.getElementById('editBorrowBookRows');
        const editBorrowBookRowTemplate = document.getElementById('editBorrowBookRowTemplate');
        let editBorrowRowIndex = 0;

        const buildEditBorrowRow = (index, item = {}) => {
            if (!editBorrowBookRowTemplate) {
                return null;
            }

            const html = editBorrowBookRowTemplate.innerHTML.replaceAll('__INDEX__', index);
            const wrapper = document.createElement('div');
            wrapper.innerHTML = html.trim();
            const row = wrapper.firstElementChild;

            if (!row) {
                return null;
            }

            const select = row.querySelector('select');
            if (select && item.book_id) {
                select.value = String(item.book_id);
            }

            const quantityInput = row.querySelector('input[type="number"]');
            if (quantityInput && item.quantity) {
                quantityInput.value = item.quantity;
            }

            const removeButton = row.querySelector('.removeEditBorrowBookRow');
            if (removeButton && editBorrowBookRows) {
                removeButton.addEventListener('click', () => {
                    if (editBorrowBookRows.children.length > 1) {
                        row.remove();
                    }
                });
            }

            return row;
        };

        if (editBorrowAddRow && editBorrowBookRows) {
            editBorrowAddRow.addEventListener('click', () => {
                const row = buildEditBorrowRow(editBorrowRowIndex);
                if (row) {
                    editBorrowBookRows.appendChild(row);
                    editBorrowRowIndex += 1;
                }
            });
        }

        function openEditBorrowModal(button) {
            const modal = document.getElementById('editBorrowModal');
            const form = document.getElementById('editBorrowForm');
            const studentName = button?.dataset?.studentName ?? '';
            const studentNumber = button?.dataset?.studentNumber ?? '';
            const borrowDate = button?.dataset?.borrowDate ?? '';
            const dueDate = button?.dataset?.dueDate ?? '';
            const borrowItems = JSON.parse(button?.dataset?.borrowItems ?? '[]');

            if (form) {
                form.action = button?.dataset?.updateUrl ?? '';
            }

            const studentField = document.getElementById('edit_borrow_student');
            if (studentField) {
                studentField.value = studentName && studentNumber
                    ? `${studentName} (${studentNumber})`
                    : studentName;
            }

            const borrowDateField = document.getElementById('edit_borrow_date');
            if (borrowDateField) {
                borrowDateField.value = borrowDate;
            }

            const dueDateField = document.getElementById('edit_borrow_due_date');
            if (dueDateField) {
                dueDateField.value = dueDate;
            }

            const borrowDateHidden = document.getElementById('edit_borrow_date_hidden');
            if (borrowDateHidden) {
                borrowDateHidden.value = borrowDate;
            }

            if (editBorrowBookRows) {
                editBorrowBookRows.innerHTML = '';
                editBorrowRowIndex = 0;

                if (borrowItems.length === 0) {
                    const row = buildEditBorrowRow(editBorrowRowIndex);
                    if (row) {
                        editBorrowBookRows.appendChild(row);
                        editBorrowRowIndex += 1;
                    }
                } else {
                    borrowItems.forEach((item) => {
                        const row = buildEditBorrowRow(editBorrowRowIndex, item);
                        if (row) {
                            editBorrowBookRows.appendChild(row);
                            editBorrowRowIndex += 1;
                        }
                    });
                }
            }

            if (modal) {
                modal.classList.remove('hidden');
            }
        }

        const returnBorrowModal = document.getElementById('returnBorrowModal');
        const returnBorrowForm = document.getElementById('returnBorrowForm');
        const returnBorrowSelect = document.getElementById('returnBorrowItemSelect');
        const returnBorrowQuantity = document.getElementById('returnBorrowQuantity');
        const returnBorrowRemaining = document.getElementById('returnBorrowRemaining');
        const returnAllBorrowForm = document.getElementById('returnAllBorrowForm');
        const returnAllBorrowBtn = document.getElementById('returnAllBorrowBtn');

        const syncReturnBorrowFields = () => {
            if (!returnBorrowSelect) {
                return;
            }

            const option = returnBorrowSelect.options[returnBorrowSelect.selectedIndex];
            if (!option) {
                return;
            }

            const remaining = Number(option.dataset.remaining ?? '0');
            if (returnBorrowForm) {
                returnBorrowForm.action = option.value;
            }

            if (returnBorrowRemaining) {
                returnBorrowRemaining.textContent = remaining > 0 ? `Remaining: ${remaining}` : 'No remaining copies';
            }

            if (returnBorrowQuantity) {
                returnBorrowQuantity.max = remaining > 0 ? remaining : 1;
                returnBorrowQuantity.value = remaining > 0 ? 1 : 0;
            }
        };

        function openReturnBorrowModal(button) {
            const items = JSON.parse(button?.dataset?.returnItems ?? '[]');
            const returnAllUrl = button?.dataset?.returnAllUrl ?? '';

            if (returnAllBorrowForm) {
                returnAllBorrowForm.action = returnAllUrl;
            }

            if (returnBorrowSelect) {
                returnBorrowSelect.innerHTML = '';
                items.forEach((item) => {
                    const option = document.createElement('option');
                    option.value = item.return_url;
                    option.dataset.remaining = item.remaining;
                    option.textContent = `${item.title} (remaining: ${item.remaining})`;
                    returnBorrowSelect.appendChild(option);
                });
            }

            syncReturnBorrowFields();

            if (returnBorrowModal) {
                returnBorrowModal.classList.remove('hidden');
            }
        }

        if (returnBorrowSelect) {
            returnBorrowSelect.addEventListener('change', syncReturnBorrowFields);
        }

        if (returnAllBorrowBtn && returnAllBorrowForm) {
            returnAllBorrowBtn.addEventListener('click', () => {
                if (!returnAllBorrowForm.action) {
                    return;
                }

                returnAllBorrowForm.submit();
            });
        }

        if (borrowBookRows) {
            let rowIndex = borrowBookRows.children.length;

            const bindRow = (row) => {
                const removeButton = row.querySelector('.removeBorrowBookRow');
                if (removeButton) {
                    removeButton.addEventListener('click', () => {
                        if (borrowBookRows.children.length > 1) {
                            row.remove();
                        }
                    });
                }
            };

            Array.from(borrowBookRows.children).forEach(bindRow);

            if (addBorrowBookRow && borrowBookRowTemplate) {
                addBorrowBookRow.addEventListener('click', () => {
                    const html = borrowBookRowTemplate.innerHTML.replaceAll('__INDEX__', rowIndex);
                    const wrapper = document.createElement('div');
                    wrapper.innerHTML = html.trim();
                    const newRow = wrapper.firstElementChild;
                    if (newRow) {
                        borrowBookRows.appendChild(newRow);
                        bindRow(newRow);
                        rowIndex += 1;
                    }
                });
            }
        }
    </script>
    <script>
        // Student search/typeahead for Add Borrow modal
        (function () {
            const searchInput = document.getElementById('add_borrow_student_search');
            const dropdown = document.getElementById('addStudentDropdown');
            const hiddenInput = document.getElementById('add_borrow_student_id');

            if (!searchInput || !dropdown || !hiddenInput) return;

            const items = Array.from(dropdown.querySelectorAll('li'));

            const filter = (q) => {
                const term = q.trim().toLowerCase();
                let visible = 0;
                items.forEach((li) => {
                    const text = li.textContent.trim().toLowerCase();
                    if (!term || text.includes(term)) {
                        li.classList.remove('hidden');
                        visible += 1;
                    } else {
                        li.classList.add('hidden');
                    }
                });

                if (visible > 0) {
                    dropdown.classList.remove('hidden');
                } else {
                    dropdown.classList.add('hidden');
                }
            };

            searchInput.addEventListener('input', (e) => {
                hiddenInput.value = '';
                filter(e.target.value);
            });

            items.forEach((li) => {
                li.addEventListener('click', () => {
                    const id = li.dataset.id;
                    const name = li.dataset.name;
                    const number = li.dataset.number;
                    hiddenInput.value = id;
                    searchInput.value = `${name} (${number})`;
                    dropdown.classList.add('hidden');
                });
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', (e) => {
                if (!dropdown.contains(e.target) && e.target !== searchInput) {
                    dropdown.classList.add('hidden');
                }
            });

            // show all on focus
            searchInput.addEventListener('focus', () => filter(searchInput.value));
        })();
    </script>
</x-layouts.layout>
