<x-layouts.layout title="Settings" activePage="settings">
    <x-slot:header>
        @include('components.header-sections.headers')
    </x-slot:header>

    <!-- Page Heading -->
    <div class="flex items-center justify-between mb-6 animate-fade-in">
        <div>
            <h1 class="text-2xl font-bold text-white">Settings</h1>
            <p class="text-gray-400 text-sm mt-1">Manage profile information and preferences</p>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 glass-card shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 glass-card shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 glass-card shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-layouts.layout>
