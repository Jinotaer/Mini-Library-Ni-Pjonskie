<x-layouts.layout title="Student Management" activePage="students">
    <x-slot:header>
        @include('components.header-sections.headers')
    </x-slot:header>
    <!-- Page Heading -->
    <div class="flex items-center justify-between mb-6 animate-fade-in">
        <div>
            <h1 class="text-2xl font-bold text-white">Student Management</h1>
            <p class="text-gray-400 text-sm mt-1">Manage student records and enrollments</p>
        </div>
        <button onclick="document.getElementById('addStudentModal').classList.remove('hidden')"
            class="flex items-center space-x-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition-all hover:shadow-lg hover:shadow-indigo-500/30 transform hover:-translate-y-0.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Add Student</span>
        </button>
    </div>

    <!-- Table Card -->
    <div class="glass-card rounded-2xl p-6 animate-fade-in" style="animation-delay: 0.1s">

        <!-- Search Bar -->
        <div class="mb-5">
            <div class="relative max-w-md">
                <svg class="w-4 h-4 text-gray-500 absolute left-3 top-1/2 -translate-y-1/2" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" placeholder="Search by Name"
                    class="w-full bg-white/5 border border-white/10 rounded-xl pl-10 pr-4 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all">
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/10">
                        <th class="text-left py-3 px-4 text-xs font-semibold text-indigo-400 uppercase tracking-wider">
                            Student ID</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-indigo-400 uppercase tracking-wider">
                            Email</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-indigo-400 uppercase tracking-wider">
                            Full Name</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-indigo-400 uppercase tracking-wider">
                            Course</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-indigo-400 uppercase tracking-wider">
                            Contact</th>
                        <th class="text-right py-3 px-4 text-xs font-semibold text-indigo-400 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach ($students as $index => $student)
                        <tr class="hover:bg-white/5 transition-colors group animate-slide-in"
                            style="animation-delay: {{ 0.15 + $index * 0.05 }}s; opacity: 0;">
                            <td class="py-3.5 px-4">
                                <span class="text-gray-400 text-sm font-mono">{{ $student['student_number'] }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="text-white text-sm font-medium">{{ $student['email'] }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="text-white text-sm font-medium">{{ $student['full_name'] }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="text-white text-sm font-medium">{{ $student['course'] }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="text-gray-300 text-sm">{{ $student['contact'] }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex items-center justify-end space-x-2">
                                    <!-- Edit Button -->
                                    <button type="button" data-update-url="{{ route('students.update', $student) }}"
                                        data-student-number="{{ $student->student_number }}"
                                        data-first-name="{{ $student->first_name }}"
                                        data-last-name="{{ $student->last_name }}" data-email="{{ $student->email }}"
                                        data-course="{{ $student->course }}" data-contact="{{ $student->contact }}"
                                        onclick="openEditModal(this)"
                                        class="p-2 rounded-lg bg-indigo-500/10 text-indigo-400 hover:bg-indigo-500/20 hover:text-indigo-300 transition-all"
                                        title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <!-- Delete Button -->
                                    <button type="button"
                                        data-delete-url="{{ route('students.destroy', $student) }}"
                                        data-student-name="{{ $student->full_name }}"
                                        onclick="openDeleteModal(this)"
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

    @include('components.student.add-student-modal')
    @include('components.student.edit-student-modal')
    @include('components.student.delete-student-modal')

    <script>
        // --- Open Edit Modal ---
        function openEditModal(button) {
            const form = document.getElementById('editStudentForm');
            form.action = button.dataset.updateUrl;
            document.getElementById('edit_student_number').value = button.dataset.studentNumber ?? '';
            document.getElementById('edit_first_name').value = button.dataset.firstName ?? '';
            document.getElementById('edit_last_name').value = button.dataset.lastName ?? '';
            document.getElementById('edit_email').value = button.dataset.email ?? '';
            document.getElementById('edit_course').value = button.dataset.course ?? '';
            document.getElementById('edit_contact').value = button.dataset.contact ?? '';
            document.getElementById('editStudentModal').classList.remove('hidden');
            showToast('Editing student: ' + (button.dataset.firstName ?? '') + ' ' + (button.dataset.lastName ?? ''), 'info');
        }

        function openDeleteModal(button) {
            const modal = document.getElementById('deleteConfirmModal');
            const nameEl = document.getElementById('deleteStudentName');
            const form = document.getElementById('deleteStudentForm');
            const studentName = button?.dataset?.studentName ?? '';
            const deleteUrl = button?.dataset?.deleteUrl ?? '';

            if (nameEl) {
                nameEl.textContent = studentName;
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
