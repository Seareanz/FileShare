@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex flex-col items-center justify-between gap-4 sm:flex-row">
        <p class="text-sm text-slate-400">
            {{ __('Showing') }}
            <span class="font-medium text-slate-200">{{ $paginator->firstItem() }}</span>
            {{ __('to') }}
            <span class="font-medium text-slate-200">{{ $paginator->lastItem() }}</span>
            {{ __('of') }}
            <span class="font-medium text-slate-200">{{ $paginator->total() }}</span>
            {{ __('results') }}
        </p>

        <div class="flex items-center gap-1">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span class="inline-flex h-9 items-center justify-center rounded-lg border border-slate-800 bg-slate-900/40 px-3 text-sm text-slate-600 cursor-not-allowed">
                    &larr;
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                   class="inline-flex h-9 items-center justify-center rounded-lg border border-slate-700 bg-slate-900 px-3 text-sm font-medium text-slate-300 transition hover:bg-slate-800 hover:text-white">
                    &larr;
                </a>
            @endif

            {{-- Elements --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="inline-flex h-9 w-9 items-center justify-center text-sm text-slate-600">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page"
                                  class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-indigo-500/50 bg-indigo-600 text-sm font-semibold text-white">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                               class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-700 bg-slate-900 text-sm font-medium text-slate-300 transition hover:bg-slate-800 hover:text-white">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                   class="inline-flex h-9 items-center justify-center rounded-lg border border-slate-700 bg-slate-900 px-3 text-sm font-medium text-slate-300 transition hover:bg-slate-800 hover:text-white">
                    &rarr;
                </a>
            @else
                <span class="inline-flex h-9 items-center justify-center rounded-lg border border-slate-800 bg-slate-900/40 px-3 text-sm text-slate-600 cursor-not-allowed">
                    &rarr;
                </span>
            @endif
        </div>
    </nav>
@endif
