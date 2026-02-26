<x-guest-layout>
    <div class="mb-6 space-y-1">
        <h1 class="text-2xl font-semibold text-white">Welcome back</h1>
        <p class="text-sm text-gray-400">Sign in to manage your library operations.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" required autofocus
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="mt-1 block w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between text-sm text-gray-400">
            <label for="remember_me" class="inline-flex items-center gap-2">
                <input id="remember_me" type="checkbox"
                    class="h-4 w-4 rounded border-white/20 bg-white/10 text-indigo-500 focus:ring-indigo-500/60"
                    name="remember">
                {{ __('Remember me') }}
            </label>

            @if (Route::has('password.request'))
                <a class="text-indigo-300 hover:text-indigo-200 transition-colors" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="flex items-center justify-between pt-2 text-sm text-gray-400">
            <span>New here?</span>
            <a class="text-indigo-300 hover:text-indigo-200 transition-colors" href="{{ route('register') }}">
                {{ __('Create an account') }}
            </a>
        </div>

        <x-primary-button class="mt-4 w-full justify-center">
            {{ __('Log in') }}
        </x-primary-button>
    </form>
</x-guest-layout>
