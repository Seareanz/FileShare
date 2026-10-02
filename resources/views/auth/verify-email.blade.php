<x-guest-layout>
    <h1 class="text-xl font-semibold text-white">{{ __('Verify your email') }}</h1>
    <p class="mt-1 mb-6 text-sm text-slate-400">
        {{ __('Thanks for signing up! Please verify your email address by clicking the link we just emailed you.') }}
    </p>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 rounded-lg border border-emerald-500/30 bg-emerald-500/10 px-3 py-2 text-sm font-medium text-emerald-300">
            {{ __('A new verification link has been sent to your email address.') }}
        </div>
    @endif

    <div class="flex items-center justify-between gap-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button>{{ __('Resend Verification Email') }}</x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-slate-400 hover:text-white underline-offset-4 hover:underline transition">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
