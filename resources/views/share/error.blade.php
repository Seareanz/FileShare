<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? __('File unavailable') }} — {{ config('app.name', 'FileShare') }}</title>
        <meta name="robots" content="noindex, nofollow">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-950 font-sans text-slate-300 antialiased">

        <div class="pointer-events-none fixed inset-0 overflow-hidden">
            <div class="absolute -top-32 left-1/2 h-[30rem] w-[30rem] -translate-x-1/2 rounded-full bg-rose-600/10 blur-[120px]"></div>
        </div>

        <div class="relative flex min-h-screen flex-col items-center justify-center px-4 py-12">

            <a href="{{ url('/') }}" class="mb-8 flex items-center gap-2.5">
                <x-application-logo class="h-9 w-9 text-indigo-400" />
                <span class="text-lg font-bold tracking-tight text-white">FileShare</span>
            </a>

            <div class="w-full max-w-md rounded-2xl border border-slate-800 bg-slate-900/70 p-7 text-center shadow-2xl shadow-black/50 backdrop-blur sm:p-8">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-rose-500/15 text-rose-300">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>

                <h1 class="mt-5 text-lg font-semibold text-white">{{ $title ?? __('File unavailable') }}</h1>
                <p class="mt-2 text-sm leading-relaxed text-slate-400">{{ $message }}</p>

                <a href="{{ url('/') }}"
                   class="mt-7 inline-flex w-full items-center justify-center gap-2 rounded-xl border border-slate-700 bg-slate-800 px-5 py-3 text-sm font-semibold text-slate-200 transition hover:bg-slate-700 hover:text-white">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    {{ __('Back to FileShare') }}
                </a>
            </div>

            <p class="mt-8 text-center text-xs text-slate-500">{{ config('app.name', 'FileShare') }}</p>
        </div>
    </body>
</html>
