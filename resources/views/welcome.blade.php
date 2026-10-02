<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'FileShare') }} — Simple, secure file sharing</title>
        <meta name="description" content="Upload a file, get a unique link, share it with anyone. Secure private storage, expiring links, and download tracking.">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-950 font-sans text-slate-300 antialiased selection:bg-indigo-500/30 selection:text-white">

        {{-- ambient glow --}}
        <div class="pointer-events-none fixed inset-0 overflow-hidden">
            <div class="absolute -top-40 left-1/2 h-[36rem] w-[36rem] -translate-x-1/2 rounded-full bg-indigo-600/20 blur-[120px]"></div>
            <div class="absolute top-1/3 -right-32 h-[28rem] w-[28rem] rounded-full bg-violet-600/10 blur-[120px]"></div>
        </div>

        <div class="relative">

            {{-- ============ NAV ============ --}}
            <header class="sticky top-0 z-40 border-b border-slate-800/70 bg-slate-950/80 backdrop-blur">
                <nav class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
                    <a href="{{ url('/') }}" class="flex items-center gap-2.5">
                        <x-application-logo class="h-9 w-9 text-indigo-400" />
                        <span class="text-lg font-bold tracking-tight text-white">FileShare</span>
                    </a>

                    <div class="hidden items-center gap-8 md:flex">
                        <a href="#features" class="text-sm font-medium text-slate-400 transition hover:text-white">Features</a>
                        <a href="#how" class="text-sm font-medium text-slate-400 transition hover:text-white">How it works</a>
                        <a href="#formats" class="text-sm font-medium text-slate-400 transition hover:text-white">Formats</a>
                    </div>

                    <div class="flex items-center gap-3">
                        @auth
                            <a href="{{ route('dashboard') }}"
                               class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-indigo-600/20 transition hover:bg-indigo-500">
                                Go to Dashboard
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="hidden rounded-lg px-4 py-2 text-sm font-medium text-slate-300 transition hover:bg-slate-800/60 hover:text-white sm:inline-flex">
                                Log in
                            </a>
                            <a href="{{ route('register') }}"
                               class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-indigo-600/20 transition hover:bg-indigo-500">
                                Get started
                            </a>
                        @endauth
                    </div>
                </nav>
            </header>

            {{-- ============ HERO ============ --}}
            <section class="mx-auto max-w-7xl px-4 pt-20 pb-16 sm:px-6 sm:pt-28 lg:px-8">
                <div class="mx-auto max-w-3xl text-center">
                    <span class="inline-flex items-center gap-2 rounded-full border border-slate-700/70 bg-slate-900/70 px-3.5 py-1.5 text-xs font-medium text-slate-300">
                        <span class="relative flex h-1.5 w-1.5">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                        </span>
                        Private storage &middot; No public file paths
                    </span>

                    <h1 class="mt-6 text-4xl font-extrabold leading-[1.1] tracking-tight text-white sm:text-5xl lg:text-6xl">
                        Share files with a
                        <span class="bg-gradient-to-r from-indigo-400 via-violet-400 to-indigo-400 bg-clip-text text-transparent">single link</span>
                    </h1>

                    <p class="mx-auto mt-6 max-w-2xl text-lg leading-relaxed text-slate-400">
                        Upload a file, get a unique share link, and send it to anyone. Files stay in private storage,
                        links can expire automatically, and every download is tracked.
                    </p>

                    <div class="mt-10 flex flex-col items-center justify-center gap-3 sm:flex-row">
                        @auth
                            <a href="{{ route('files.create') }}"
                               class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-600 px-6 py-3.5 text-sm font-semibold text-white shadow-xl shadow-indigo-600/25 transition hover:bg-indigo-500 sm:w-auto">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                </svg>
                                Upload a file
                            </a>
                            <a href="{{ route('dashboard') }}"
                               class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-slate-700 bg-slate-900 px-6 py-3.5 text-sm font-semibold text-slate-200 transition hover:border-slate-600 hover:text-white sm:w-auto">
                                View my files
                            </a>
                        @else
                            <a href="{{ route('register') }}"
                               class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-600 px-6 py-3.5 text-sm font-semibold text-white shadow-xl shadow-indigo-600/25 transition hover:bg-indigo-500 sm:w-auto">
                                Create free account
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                            <a href="{{ route('login') }}"
                               class="inline-flex w-full items-center justify-center rounded-xl border border-slate-700 bg-slate-900 px-6 py-3.5 text-sm font-semibold text-slate-200 transition hover:border-slate-600 hover:text-white sm:w-auto">
                                I already have an account
                            </a>
                        @endauth
                    </div>

                    <p class="mt-6 text-xs text-slate-500">Up to 50 MB per file &middot; 14 supported file types &middot; Free</p>
                </div>

                {{-- Mock share card --}}
                <div class="mx-auto mt-16 max-w-md">
                    <div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-black/50 backdrop-blur">
                        <div class="flex items-center gap-3">
                            <x-file-icon name="report.pdf" />
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-white">report.pdf</p>
                                <p class="text-xs text-slate-500">2.4 MB &middot; Uploaded just now</p>
                            </div>
                            <span class="rounded-full bg-emerald-500/15 px-2 py-0.5 text-[11px] font-semibold text-emerald-300">Active</span>
                        </div>

                        <div class="mt-5 flex items-center gap-2 rounded-lg border border-slate-800 bg-slate-950/70 px-3 py-2.5">
                            <svg class="h-4 w-4 shrink-0 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                            </svg>
                            <code class="truncate font-mono text-xs text-indigo-300">/s/8xK92LmQ4tRv7YnP</code>
                        </div>

                        <div class="mt-4 grid grid-cols-3 divide-x divide-slate-800 rounded-lg border border-slate-800 bg-slate-950/40 text-center">
                            <div class="px-3 py-2.5">
                                <p class="text-sm font-semibold text-white">12</p>
                                <p class="text-[11px] text-slate-500">Downloads</p>
                            </div>
                            <div class="px-3 py-2.5">
                                <p class="text-sm font-semibold text-white">7 days</p>
                                <p class="text-[11px] text-slate-500">Expires</p>
                            </div>
                            <div class="px-3 py-2.5">
                                <p class="text-sm font-semibold text-white">Private</p>
                                <p class="text-[11px] text-slate-500">Storage</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ============ FEATURES ============ --}}
            <section id="features" class="border-t border-slate-800/70 py-20 sm:py-24">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mx-auto max-w-2xl text-center">
                        <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">Everything you need, nothing you don't</h2>
                        <p class="mt-4 text-slate-400">A focused set of features built around one job: getting a file from you to someone else, safely.</p>
                    </div>

                    <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @php
                            $features = [
                                ['Upload in seconds', 'Drag and drop a file, pick an expiration, and get a share link instantly. No setup, no friction.', 'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12'],
                                ['Unique share links', 'Every file gets a cryptographically random token. Only people with the link can reach it.', 'M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1'],
                                ['Expiring links', 'Set links to never expire, or automatically stop working after 1, 7, or 30 days.', 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                                ['Private storage', 'Files live outside the public directory. Downloads are streamed through authorization checks.', 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z'],
                                ['Download tracking', 'See exactly how many times each file has been downloaded, right from your dashboard.', 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                                ['You own your files', 'Only you can view, download, or delete your uploads. Deleting removes the file from disk.', 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                            ];
                        @endphp

                        @foreach ($features as [$title, $desc, $icon])
                            <div class="group rounded-2xl border border-slate-800 bg-slate-900/40 p-6 transition hover:border-slate-700 hover:bg-slate-900/70">
                                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-500/15 text-indigo-300 transition group-hover:bg-indigo-500/25">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
                                    </svg>
                                </div>
                                <h3 class="mt-5 text-base font-semibold text-white">{{ $title }}</h3>
                                <p class="mt-2 text-sm leading-relaxed text-slate-400">{{ $desc }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            {{-- ============ HOW IT WORKS ============ --}}
            <section id="how" class="border-t border-slate-800/70 py-20 sm:py-24">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mx-auto max-w-2xl text-center">
                        <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">Three steps, that's it</h2>
                        <p class="mt-4 text-slate-400">From upload to shared link in well under a minute.</p>
                    </div>

                    <div class="mt-14 grid gap-8 md:grid-cols-3">
                        @php
                            $steps = [
                                ['Upload your file', 'Choose a file from your device, or drag it straight onto the upload area. 50 MB max per file.'],
                                ['Copy the share link', 'We generate a unique, unguessable link for your file the moment the upload finishes.'],
                                ['Send it anywhere', 'Paste the link into a chat, an email, or a ticket. Anyone with it can download the file.'],
                            ];
                        @endphp

                        @foreach ($steps as $i => [$title, $desc])
                            <div class="relative">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full border border-indigo-500/40 bg-indigo-500/10 text-sm font-bold text-indigo-300">
                                    {{ $i + 1 }}
                                </div>
                                @if ($i < 2)
                                    <div class="absolute left-12 top-5 hidden h-px w-[calc(100%-3rem)] bg-gradient-to-r from-indigo-500/40 to-transparent md:block"></div>
                                @endif
                                <h3 class="mt-5 text-base font-semibold text-white">{{ $title }}</h3>
                                <p class="mt-2 text-sm leading-relaxed text-slate-400">{{ $desc }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            {{-- ============ FORMATS ============ --}}
            <section id="formats" class="border-t border-slate-800/70 py-20 sm:py-24">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mx-auto max-w-2xl text-center">
                        <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">Supported file types</h2>
                        <p class="mt-4 text-slate-400">A strict whitelist keeps dangerous file types out of your storage.</p>
                    </div>

                    <div class="mx-auto mt-10 flex max-w-3xl flex-wrap justify-center gap-2.5">
                        @foreach (['jpg','jpeg','png','gif','webp','pdf','txt','doc','docx','xls','xlsx','ppt','pptx','zip'] as $ext)
                            <span class="rounded-lg border border-slate-800 bg-slate-900/60 px-3.5 py-1.5 font-mono text-xs font-medium uppercase text-slate-300">
                                .{{ $ext }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </section>

            {{-- ============ CTA ============ --}}
            <section class="border-t border-slate-800/70 py-20 sm:py-24">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="relative overflow-hidden rounded-3xl border border-slate-800 bg-gradient-to-br from-slate-900 via-slate-900 to-indigo-950/50 px-6 py-14 text-center sm:px-14">
                        <div class="pointer-events-none absolute -top-24 left-1/2 h-64 w-64 -translate-x-1/2 rounded-full bg-indigo-500/20 blur-[100px]"></div>

                        <div class="relative">
                            <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">Ready to share your first file?</h2>
                            <p class="mx-auto mt-4 max-w-xl text-slate-400">Create an account and upload a file in under a minute. No credit card, no clutter.</p>

                            <div class="mt-9 flex flex-col items-center justify-center gap-3 sm:flex-row">
                                @auth
                                    <a href="{{ route('files.create') }}"
                                       class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-600 px-6 py-3.5 text-sm font-semibold text-white shadow-xl shadow-indigo-600/25 transition hover:bg-indigo-500 sm:w-auto">
                                        Upload a file
                                    </a>
                                @else
                                    <a href="{{ route('register') }}"
                                       class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-600 px-6 py-3.5 text-sm font-semibold text-white shadow-xl shadow-indigo-600/25 transition hover:bg-indigo-500 sm:w-auto">
                                        Get started free
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('login') }}"
                                       class="inline-flex w-full items-center justify-center rounded-xl border border-slate-700 bg-slate-900 px-6 py-3.5 text-sm font-semibold text-slate-200 transition hover:border-slate-600 hover:text-white sm:w-auto">
                                        Log in
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ============ FOOTER ============ --}}
            <footer class="border-t border-slate-800/70 py-10">
                <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-4 px-4 sm:flex-row sm:px-6 lg:px-8">
                    <div class="flex items-center gap-2.5">
                        <x-application-logo class="h-7 w-7 text-indigo-400" />
                        <span class="text-sm font-semibold text-white">FileShare</span>
                    </div>

                    <p class="text-xs text-slate-500">&copy; {{ date('Y') }} FileShare. Simple, secure file sharing.</p>

                    <div class="flex items-center gap-5">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-xs text-slate-400 transition hover:text-white">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-xs text-slate-400 transition hover:text-white">Log in</a>
                            <a href="{{ route('register') }}" class="text-xs text-slate-400 transition hover:text-white">Register</a>
                        @endauth
                    </div>
                </div>
            </footer>

        </div>
    </body>
</html>
