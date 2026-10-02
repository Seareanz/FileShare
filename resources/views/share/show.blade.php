<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $file->original_name }} — {{ config('app.name', 'FileShare') }}</title>
        <meta name="robots" content="noindex, nofollow">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-950 font-sans text-slate-300 antialiased">

        <div class="pointer-events-none fixed inset-0 overflow-hidden">
            <div class="absolute -top-32 left-1/2 h-[30rem] w-[30rem] -translate-x-1/2 rounded-full bg-indigo-600/15 blur-[120px]"></div>
        </div>

        <div class="relative flex min-h-screen flex-col items-center justify-center px-4 py-12">

            <a href="{{ url('/') }}" class="mb-8 flex items-center gap-2.5">
                <x-application-logo class="h-9 w-9 text-indigo-400" />
                <span class="text-lg font-bold tracking-tight text-white">FileShare</span>
            </a>

            <div class="w-full max-w-md rounded-2xl border border-slate-800 bg-slate-900/70 p-7 shadow-2xl shadow-black/50 backdrop-blur sm:p-8">

                <div class="text-center">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-indigo-500/15 text-indigo-300">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>

                    <h1 class="mt-5 break-words text-lg font-semibold text-white">{{ $file->original_name }}</h1>

                    <div class="mt-3 flex flex-wrap items-center justify-center gap-2 text-xs text-slate-400">
                        <span class="rounded-md border border-slate-700/70 bg-slate-950/60 px-2.5 py-1 font-mono font-medium uppercase text-slate-300">
                            {{ strtoupper(pathinfo($file->original_name, PATHINFO_EXTENSION)) }}
                        </span>
                        <span class="rounded-md border border-slate-700/70 bg-slate-950/60 px-2.5 py-1">{{ $file->getFormattedSize() }}</span>
                        <span class="rounded-md border border-slate-700/70 bg-slate-950/60 px-2.5 py-1">{{ $file->created_at->format('M d, Y') }}</span>
                    </div>
                </div>

                <a href="{{ route('share.download', $file->token) }}"
                   class="mt-7 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3.5 text-sm font-semibold text-white shadow-xl shadow-indigo-600/25 transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-slate-900">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    {{ __('Download File') }}
                </a>

                <div class="mt-6 grid grid-cols-2 divide-x divide-slate-800 rounded-xl border border-slate-800 bg-slate-950/40 text-center">
                    <div class="px-3 py-3">
                        <p class="text-sm font-semibold text-white">{{ number_format($file->download_count) }}</p>
                        <p class="text-[11px] text-slate-500">{{ __('Downloads') }}</p>
                    </div>
                    <div class="px-3 py-3">
                        <p class="text-sm font-semibold text-white">
                            @if ($file->expires_at)
                                {{ $file->expires_at->format('M d, Y') }}
                            @else
                                {{ __('Never') }}
                            @endif
                        </p>
                        <p class="text-[11px] text-slate-500">{{ __('Expires') }}</p>
                    </div>
                </div>
            </div>

            <p class="mt-8 text-center text-xs text-slate-500">
                {{ __('Shared securely via') }} <span class="font-medium text-slate-400">FileShare</span>
            </p>
        </div>
    </body>
</html>
