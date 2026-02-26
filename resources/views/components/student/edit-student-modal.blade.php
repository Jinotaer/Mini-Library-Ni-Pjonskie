 <!-- Edit Student Modal -->
    <div id="editStudentModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"
            onclick="document.getElementById('editStudentModal').classList.add('hidden')"></div>

        <!-- Modal Content -->
        <div
            class="relative bg-[#1a1a2e] border border-white/10 rounded-2xl shadow-2xl w-full max-w-lg mx-4 p-6 animate-fade-in">
            <!-- Close Button -->
            <button onclick="document.getElementById('editStudentModal').classList.add('hidden')"
                class="absolute top-4 right-4 text-gray-400 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Header -->
            <h2 class="text-xl font-bold text-white mb-1">Edit Student</h2>
            <p class="text-gray-400 text-sm mb-6">Update student information below.</p>

            <!-- Form -->
            <form id="editStudentForm" action="" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="flex flex-row gap-7">
                    <div>
                        <!-- Student ID -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Student ID</label>
                            <input type="text" name="student_number" id="edit_student_number"
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all">
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Email</label>
                            <input type="email" name="email" id="edit_email"
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all">
                        </div>

                        <!-- Course -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Course</label>
                            <input type="text" name="course" id="edit_course"
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all">
                        </div>
                    </div>


                    <div>
                        <!-- Name -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">First Name</label>
                            <input type="text" name="first_name" id="edit_first_name"
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all">
                        </div>

                        <!-- Name -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Last Name</label>
                            <input type="text" name="last_name" id="edit_last_name"
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all">
                        </div>

                        <!-- Contact -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Contact</label>
                            <input type="text" name="contact" id="edit_contact"
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all">
                        </div>
                    </div>


                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-end space-x-3 pt-2">
                    <button type="button"
                        onclick="document.getElementById('editStudentModal').classList.add('hidden')"
                        class="px-5 py-2.5 rounded-xl text-sm font-medium text-gray-300 hover:text-white hover:bg-white/5 transition-all">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold transition-all hover:shadow-lg hover:shadow-indigo-500/30">
                        Update Student
                    </button>
                </div>
            </form>
        </div>
    </div>
