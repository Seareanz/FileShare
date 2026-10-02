<x-guest-layout>
    <h1 class="text-xl font-semibold text-white">{{ __('Forgot your password?') }}</h1>
    <p class="mt-1 mb-6 text-sm text-slate-400">
        {{ __('Enter your email and we will send you a password reset link.') }}
    </p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-2" type="email" name="email" :value="old('email')" required autofocus placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <x-primary-button class="w-full">
            {{ __('Email Password Reset Link') }}
        </x-primary-button>

        <p class="text-center text-sm text-slate-400">
            <a href="{{ route('login') }}" class="font-medium text-indigo-400 hover:text-indigo-300 transition">{{ __('Back to log in') }}</a>
        </p>
    </form>
</x-guest-layout>
