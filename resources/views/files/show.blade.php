<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-white">{{ __('File Details') }}</h2>
                <p class="mt-1 text-sm text-slate-400">{{ __('Share link, status, and download activity for this file.') }}</p>
            </div>

            <a href="{{ route('files.index') }}"
               class="inline-flex items-center gap-2 rounded-lg border border-slate-700 bg-slate-900 px-3.5 py-2 text-sm font-medium text-slate-300 transition hover:border-slate-600 hover:text-white">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ __('My Files') }}
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl space-y-6 sm:px-6 lg:px-8">

            {{-- ===== FILE HEADER CARD ===== --}}
            <div class="rounded-2xl border border-slate-800 bg-slate-900/60 p-6 sm:p-8">
                <div class="flex items-start gap-4">
                    <x-file-icon :name="$file->original_name" class="h-auto w-14 py-2.5 text-xs" />

                    <div class="min-w-0 flex-1">
                        <h3 class="truncate text-lg font-semibold text-white">{{ $file->original_name }}</h3>
                        <p class="mt-1 text-sm text-slate-400">
                            {{ $file->getFormattedSize() }} &middot; {{ strtoupper(pathinfo($file->original_name, PATHINFO_EXTENSION)) }} &middot;
                            {{ $file->created_at->format('M d, Y H:i') }}
                        </p>

                        <div class="mt-3">
                            @if ($file->isExpired())
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-500/15 px-2.5 py-1 text-xs font-semibold text-rose-300">
                                    <span class="h-1.5 w-1.5 rounded-full bg-rose-400"></span>
                                    {{ __('Expired') }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500/15 px-2.5 py-1 text-xs font-semibold text-emerald-300">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                                    {{ __('Active') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- ===== SHARE LINK ===== --}}
            <div class="rounded-2xl border border-slate-800 bg-slate-900/60 p-6">
                <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-400">{{ __('Share link') }}</h3>

                <div class="mt-4 flex flex-col gap-2 sm:flex-row">
                    <div class="flex flex-1 items-center gap-2 overflow-hidden rounded-lg border border-slate-800 bg-slate-950/70 px-3 py-2.5">
                        <svg class="h-4 w-4 shrink-0 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                        <code class="truncate font-mono text-xs text-indigo-300">{{ route('share.show', $file->token) }}</code>
                    </div>

                    <button type="button" data-copy="{{ route('share.show', $file->token) }}"
                            class="js-copy inline-flex items-center justify-center gap-2 rounded-lg border border-slate-700 bg-slate-800 px-4 py-2.5 text-sm font-semibold text-slate-200 transition hover:bg-slate-700 hover:text-white">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3"/>
                        </svg>
                        {{ __('Copy') }}
                    </button>

                    <a href="{{ route('share.show', $file->token) }}" target="_blank"
                       class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-700 bg-slate-800 px-4 py-2.5 text-sm font-semibold text-slate-200 transition hover:bg-slate-700 hover:text-white">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        {{ __('Open') }}
                    </a>
                </div>
            </div>

            {{-- ===== STATS ===== --}}
            <div class="grid grid-cols-2 gap-5 sm:grid-cols-3">
                <div class="rounded-2xl border border-slate-800 bg-slate-900/60 p-5">
                    <p class="text-xs font-medium uppercase tracking-wider text-slate-500">{{ __('Downloads') }}</p>
                    <p class="mt-2 text-2xl font-bold text-white">{{ number_format($file->download_count) }}</p>
                </div>

                <div class="rounded-2xl border border-slate-800 bg-slate-900/60 p-5">
                    <p class="text-xs font-medium uppercase tracking-wider text-slate-500">{{ __('Expires') }}</p>
                    <p class="mt-2 text-2xl font-bold text-white">
                        @if ($file->expires_at)
                            {{ $file->expires_at->format('M d, Y') }}
                        @else
                            {{ __('Never') }}
                        @endif
                    </p>
                </div>

                <div class="col-span-2 rounded-2xl border border-slate-800 bg-slate-900/60 p-5 sm:col-span-1">
                    <p class="text-xs font-medium uppercase tracking-wider text-slate-500">{{ __('Size') }}</p>
                    <p class="mt-2 text-2xl font-bold text-white">{{ $file->getFormattedSize() }}</p>
                </div>
            </div>

            {{-- ===== ACTIONS ===== --}}
            <div class="flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('files.download', $file) }}"
                   class="inline-flex flex-1 items-center justify-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-600/20 transition hover:bg-indigo-500">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    {{ __('Download') }}
                </a>

                <form action="{{ route('files.delete', $file) }}" method="POST" class="flex-1"
                      onsubmit="return confirm('{{ __('Delete this file permanently? This cannot be undone.') }}');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-rose-500/40 bg-rose-500/10 px-4 py-2.5 text-sm font-semibold text-rose-300 transition hover:bg-rose-500/20">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        {{ __('Delete File') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    @include('partials.copy-toast')
</x-app-layout>
