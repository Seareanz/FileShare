<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-white">{{ __('My Files') }}</h2>
                <p class="mt-1 text-sm text-slate-400">{{ __('Search, filter, and manage everything you have uploaded.') }}</p>
            </div>

            <a href="{{ route('files.create') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-600/20 transition hover:bg-indigo-500">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                {{ __('Upload File') }}
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">

            {{-- ===== FILTER BAR ===== --}}
            <div class="rounded-2xl border border-slate-800 bg-slate-900/60 p-4 sm:p-5">
                <form method="GET" action="{{ route('files.index') }}" class="flex flex-col gap-3 lg:flex-row lg:items-center">
                    <div class="relative flex-1">
                        <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="{{ __('Search files...') }}"
                               class="w-full rounded-lg border border-slate-700 bg-slate-950/60 py-2.5 pl-9 pr-3 text-sm text-slate-100 placeholder-slate-500 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30">
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row">
                        <select name="extension"
                                class="rounded-lg border border-slate-700 bg-slate-950/60 px-3 py-2.5 text-sm text-slate-100 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30">
                            <option value="">{{ __('All types') }}</option>
                            @foreach ($extensions as $ext)
                                <option value="{{ $ext }}" @selected(request('extension') === $ext)>{{ strtoupper($ext) }}</option>
                            @endforeach
                        </select>

                        <select name="sort"
                                class="rounded-lg border border-slate-700 bg-slate-950/60 px-3 py-2.5 text-sm text-slate-100 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30">
                            <option value="newest" @selected(request('sort', 'newest') === 'newest')>{{ __('Newest first') }}</option>
                            <option value="oldest" @selected(request('sort') === 'oldest')>{{ __('Oldest first') }}</option>
                            <option value="name" @selected(request('sort') === 'name')>{{ __('Name (A-Z)') }}</option>
                            <option value="size" @selected(request('sort') === 'size')>{{ __('Largest first') }}</option>
                        </select>

                        <button type="submit"
                                class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-700 bg-slate-800 px-4 py-2.5 text-sm font-semibold text-slate-200 transition hover:bg-slate-700 hover:text-white">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                            </svg>
                            {{ __('Filter') }}
                        </button>

                        @if (request()->hasAny(['search', 'extension', 'sort']))
                            <a href="{{ route('files.index') }}"
                               class="inline-flex items-center justify-center rounded-lg px-3 py-2.5 text-sm font-medium text-slate-400 transition hover:text-white">
                                {{ __('Reset') }}
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- ===== TABLE ===== --}}
            <div class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900/60">
                @if ($files->count() > 0)
                    <div class="overflow-x-auto scrollbar-thin">
                        <table class="min-w-full divide-y divide-slate-800">
                            <thead>
                                <tr class="bg-slate-950/40">
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">{{ __('File') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">{{ __('Size') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">{{ __('Uploaded') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">{{ __('Downloads') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">{{ __('Expiration') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">{{ __('Status') }}</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-400">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800">
                                @foreach ($files as $file)
                                    <tr class="transition hover:bg-slate-800/30">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <x-file-icon :name="$file->original_name" />
                                                <div class="min-w-0">
                                                    <p class="max-w-xs truncate text-sm font-medium text-white">{{ $file->original_name }}</p>
                                                    <p class="font-mono text-xs text-slate-500">{{ strtoupper(pathinfo($file->original_name, PATHINFO_EXTENSION)) }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-400">{{ $file->getFormattedSize() }}</td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-400">{{ $file->created_at->format('M d, Y') }}</td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-400">{{ number_format($file->download_count) }}</td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-400">
                                            @if ($file->expires_at)
                                                {{ $file->expires_at->format('M d, Y') }}
                                            @else
                                                <span class="text-slate-500">{{ __('Never') }}</span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
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
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-1">
                                                <button type="button"
                                                        data-copy="{{ route('share.show', $file->token) }}"
                                                        class="js-copy inline-flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-800 hover:text-indigo-300"
                                                        title="{{ __('Copy Link') }}">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                                    </svg>
                                                </button>

                                                <a href="{{ route('files.show', $file) }}"
                                                   class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-800 hover:text-slate-200"
                                                   title="{{ __('Details') }}">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                </a>

                                                <a href="{{ route('files.download', $file) }}"
                                                   class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-800 hover:text-emerald-300"
                                                   title="{{ __('Download') }}">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                    </svg>
                                                </a>

                                                <form action="{{ route('files.delete', $file) }}" method="POST" class="inline"
                                                      onsubmit="return confirm('{{ __('Delete this file permanently?') }}');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 transition hover:bg-rose-500/10 hover:text-rose-300"
                                                            title="{{ __('Delete') }}">
                                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if ($files->hasPages())
                        <div class="border-t border-slate-800 px-6 py-4">
                            {{ $files->links() }}
                        </div>
                    @endif
                @else
                    <div class="px-6 py-16 text-center">
                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-800/70 text-slate-500">
                            @if (request()->hasAny(['search', 'extension']))
                                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            @else
                                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            @endif
                        </div>

                        @if (request()->hasAny(['search', 'extension']))
                            <h3 class="mt-4 text-sm font-semibold text-white">{{ __('No files match your filters') }}</h3>
                            <p class="mt-1 text-sm text-slate-400">{{ __('Try a different search term or clear the filters.') }}</p>
                            <a href="{{ route('files.index') }}"
                               class="mt-6 inline-flex items-center gap-2 rounded-lg border border-slate-700 bg-slate-800 px-4 py-2.5 text-sm font-semibold text-slate-200 transition hover:bg-slate-700 hover:text-white">
                                {{ __('Clear filters') }}
                            </a>
                        @else
                            <h3 class="mt-4 text-sm font-semibold text-white">{{ __('No files yet') }}</h3>
                            <p class="mt-1 text-sm text-slate-400">{{ __('Upload your first file to generate a shareable link.') }}</p>
                            <a href="{{ route('files.create') }}"
                               class="mt-6 inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-600/20 transition hover:bg-indigo-500">
                                {{ __('Upload File') }}
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    @include('partials.copy-toast')
</x-app-layout>
