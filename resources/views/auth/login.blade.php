<x-guest-layout>
    <h1 class="text-xl font-semibold text-white">{{ __('Welcome back') }}</h1>
    <p class="mt-1 mb-6 text-sm text-slate-400">{{ __('Log in to manage and share your files.') }}</p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-2" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="mt-2" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="h-4 w-4 rounded border-slate-700 bg-slate-950 text-indigo-600 focus:ring-2 focus:ring-indigo-500/40" name="remember">
                <span class="ms-2 text-sm text-slate-400">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-slate-400 hover:text-white underline-offset-4 hover:underline transition" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <x-primary-button class="w-full">
            {{ __('Log in') }}
        </x-primary-button>

        <p class="text-center text-sm text-slate-400">
            {{ __("Don't have an account?") }}
            <a href="{{ route('register') }}" class="font-medium text-indigo-400 hover:text-indigo-300 transition">{{ __('Create one') }}</a>
        </p>
    </form>
</x-guest-layout>
