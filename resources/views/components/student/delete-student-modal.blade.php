<!-- Delete Confirmation Modal -->
<div id="deleteConfirmModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeDeleteModal()"></div>

    <!-- Modal Card -->
    <div class="relative bg-[#1a1a2e] border border-white/10 rounded-2xl shadow-2xl w-full max-w-sm mx-4 p-6 animate-fade">
        <form id="deleteStudentForm" method="POST" action="" class="text-center">
            @csrf
            @method('DELETE')

            <div class="w-14 h-14 bg-red-500/15 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </div>

            <h3 class="text-lg font-bold text-white mb-1">Delete Student</h3>
            <p class="text-gray-400 text-sm mb-6">
                Are you sure you want to delete
                <span id="deleteStudentName" class="text-white font-medium"></span>?
                This action cannot be undone.
            </p>

            <div class="flex items-center justify-center space-x-3">
                <button type="button" onclick="closeDeleteModal()"
                    class="px-5 py-2.5 rounded-xl text-sm font-medium text-gray-300 hover:text-white hover:bg-white/5 transition-all">
                    Cancel
                </button>

                <button type="submit"
                    class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm font-semibold transition-all hover:shadow-lg hover:shadow-red-500/30">
                    Delete
                </button>
            </div>
        </form>
    </div>
</div>
