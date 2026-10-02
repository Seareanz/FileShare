<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'FileShare') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-200 antialiased bg-slate-950">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4">

            <a href="/" class="flex items-center gap-3 group">
                <x-application-logo class="h-11 w-11 text-indigo-400 group-hover:text-indigo-300 transition" />
                <span class="text-2xl font-bold tracking-tight text-white">FileShare</span>
            </a>

            <div class="w-full sm:max-w-md mt-8 px-6 py-7 bg-slate-900/70 border border-slate-800 shadow-xl shadow-black/40 overflow-hidden sm:rounded-2xl backdrop-blur">
                {{ $slot }}
            </div>

            <p class="mt-8 text-sm text-slate-500">
                Secure file sharing &middot; &copy; {{ date('Y') }} FileShare
            </p>
        </div>
    </body>
</html>
