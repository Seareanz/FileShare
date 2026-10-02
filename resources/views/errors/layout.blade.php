<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Error') — {{ config('app.name', 'FileShare') }}</title>

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

            <div class="w-full max-w-md rounded-2xl border border-slate-800 bg-slate-900/70 p-7 text-center shadow-2xl shadow-black/50 backdrop-blur sm:p-8">
                <p class="text-5xl font-extrabold tracking-tight text-white">@yield('code')</p>

                <h1 class="mt-4 text-lg font-semibold text-white">@yield('title')</h1>
                <p class="mt-2 text-sm leading-relaxed text-slate-400">@yield('message')</p>

                <a href="{{ url('/') }}"
                   class="mt-7 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-xl shadow-indigo-600/25 transition hover:bg-indigo-500">
                    {{ __('Back to FileShare') }}
                </a>
            </div>
        </div>
    </body>
</html>
