<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-white">{{ __('Upload File') }}</h2>
                <p class="mt-1 text-sm text-slate-400">{{ __('Pick a file, choose an expiration, and get a share link.') }}</p>
            </div>

            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center gap-2 rounded-lg border border-slate-700 bg-slate-900 px-3.5 py-2 text-sm font-medium text-slate-300 transition hover:border-slate-600 hover:text-white">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ __('Back') }}
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-slate-800 bg-slate-900/60 p-6 sm:p-8">

                @if ($errors->any())
                    <div class="mb-6 flex items-start gap-3 rounded-xl border border-rose-500/30 bg-rose-500/10 px-4 py-3">
                        <svg class="mt-px h-5 w-5 shrink-0 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <div class="text-sm text-rose-300">
                            <p class="font-medium">{{ __('Upload failed') }}</p>
                            <ul class="mt-1 list-inside list-disc space-y-0.5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('files.store') }}" enctype="multipart/form-data" id="upload-form" class="space-y-7">
                    @csrf

                    {{-- ===== DROP ZONE ===== --}}
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-300">{{ __('Select file') }}</label>

                        <div id="drop-zone"
                             class="group cursor-pointer rounded-2xl border-2 border-dashed border-slate-700 bg-slate-950/40 px-6 py-12 text-center transition hover:border-indigo-500/60 hover:bg-slate-950/70">
                            <input type="file" name="file" id="file-input" class="hidden" required
                                   accept=".jpg,.jpeg,.png,.gif,.webp,.pdf,.txt,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip">

                            <div id="drop-empty">
                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-800/70 text-slate-400 transition group-hover:bg-indigo-500/15 group-hover:text-indigo-300">
                                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                </div>
                                <p class="mt-4 text-sm font-medium text-slate-200">
                                    {{ __('Drag & drop your file here, or') }}
                                    <span class="text-indigo-400">{{ __('browse') }}</span>
                                </p>
                                <p class="mt-1.5 text-xs text-slate-500">{{ __('Maximum size: 50 MB') }}</p>
                            </div>

                            <div id="drop-selected" class="hidden">
                                <div class="flex items-center gap-4 rounded-xl border border-slate-800 bg-slate-900/70 p-4 text-left">
                                    <x-file-icon :name="''" id="selected-icon" />
                                    <div class="min-w-0 flex-1">
                                        <p id="selected-name" class="truncate text-sm font-medium text-white"></p>
                                        <p id="selected-size" class="mt-0.5 text-xs text-slate-500"></p>
                                    </div>
                                    <button type="button" id="clear-file"
                                            class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-slate-400 transition hover:bg-rose-500/10 hover:text-rose-300"
                                            title="{{ __('Remove') }}">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                                <p class="mt-3 text-xs text-slate-500">{{ __('Click to choose a different file') }}</p>
                            </div>
                        </div>

                        <p class="mt-3 text-xs leading-relaxed text-slate-500">
                            {{ __('Allowed: jpg, jpeg, png, gif, webp, pdf, txt, doc, docx, xls, xlsx, ppt, pptx, zip') }}
                        </p>
                    </div>

                    {{-- ===== EXPIRATION ===== --}}
                    <div>
                        <label class="mb-3 block text-sm font-medium text-slate-300">{{ __('Expiration') }}</label>

                        <div class="grid gap-2.5 sm:grid-cols-2">
                            @foreach ([
                                'never' => ['Never', 'Link stays active indefinitely'],
                                '1day' => ['1 Day', 'Expires after 24 hours'],
                                '7days' => ['7 Days', 'Expires after one week'],
                                '30days' => ['30 Days', 'Expires after 30 days'],
                            ] as $value => [$label, $hint])
                                <label class="relative flex cursor-pointer items-start gap-3 rounded-xl border border-slate-800 bg-slate-950/40 p-4 transition hover:border-slate-700 has-[:checked]:border-indigo-500/60 has-[:checked]:bg-indigo-500/5">
                                    <input type="radio" name="expiration" value="{{ $value }}" @checked(old('expiration', 'never') === $value)
                                           class="mt-0.5 h-4 w-4 shrink-0 border-slate-700 bg-slate-950 text-indigo-600 focus:ring-2 focus:ring-indigo-500/40">
                                    <span class="min-w-0">
                                        <span class="block text-sm font-medium text-white">{{ __($label) }}</span>
                                        <span class="mt-0.5 block text-xs text-slate-500">{{ __($hint) }}</span>
                                    </span>
                                </label>
                            @endforeach
                        </div>

                        <x-input-error :messages="$errors->get('expiration')" class="mt-2" />
                    </div>

                    {{-- ===== ACTIONS ===== --}}
                    <div class="flex flex-col-reverse items-center gap-3 border-t border-slate-800 pt-6 sm:flex-row sm:justify-end">
                        <a href="{{ route('dashboard') }}"
                           class="inline-flex w-full items-center justify-center rounded-lg px-4 py-2.5 text-sm font-medium text-slate-400 transition hover:text-white sm:w-auto">
                            {{ __('Cancel') }}
                        </a>

                        <button type="submit" id="submit-btn"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-600/20 transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-slate-900 disabled:cursor-not-allowed disabled:opacity-60 sm:w-auto">
                            <svg id="submit-icon" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            <svg id="submit-spinner" class="hidden h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            <span id="submit-text">{{ __('Upload File') }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const dropZone = document.getElementById('drop-zone');
            const input = document.getElementById('file-input');
            const empty = document.getElementById('drop-empty');
            const selected = document.getElementById('drop-selected');
            const nameEl = document.getElementById('selected-name');
            const sizeEl = document.getElementById('selected-size');
            const clearBtn = document.getElementById('clear-file');
            const form = document.getElementById('upload-form');
            const submitBtn = document.getElementById('submit-btn');
            const submitText = document.getElementById('submit-text');
            const submitIcon = document.getElementById('submit-icon');
            const submitSpinner = document.getElementById('submit-spinner');
            const MAX = 50 * 1024 * 1024;

            function formatSize(bytes) {
                if (!bytes) return '0 B';
                const units = ['B', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(1024));
                return (bytes / Math.pow(1024, i)).toFixed(2) + ' ' + units[i];
            }

            function render() {
                const file = input.files && input.files[0];
                if (!file) {
                    empty.classList.remove('hidden');
                    selected.classList.add('hidden');
                    return;
                }
                nameEl.textContent = file.name;
                sizeEl.textContent = formatSize(file.size) + (file.size > MAX ? ' — exceeds 50 MB' : '');
                sizeEl.className = 'mt-0.5 text-xs ' + (file.size > MAX ? 'text-rose-400' : 'text-slate-500');
                empty.classList.add('hidden');
                selected.classList.remove('hidden');
            }

            dropZone.addEventListener('click', (e) => {
                if (e.target.closest('#clear-file')) return;
                input.click();
            });

            ['dragenter', 'dragover'].forEach((ev) =>
                dropZone.addEventListener(ev, (e) => {
                    e.preventDefault();
                    dropZone.classList.add('border-indigo-500/70', 'bg-slate-950/80');
                })
            );

            ['dragleave', 'drop'].forEach((ev) =>
                dropZone.addEventListener(ev, (e) => {
                    e.preventDefault();
                    dropZone.classList.remove('border-indigo-500/70', 'bg-slate-950/80');
                })
            );

            dropZone.addEventListener('drop', (e) => {
                const files = e.dataTransfer && e.dataTransfer.files;
                if (files && files.length) {
                    input.files = files;
                    render();
                }
            });

            input.addEventListener('change', render);

            clearBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                input.value = '';
                render();
            });

            form.addEventListener('submit', () => {
                submitBtn.disabled = true;
                submitText.textContent = 'Uploading...';
                submitIcon.classList.add('hidden');
                submitSpinner.classList.remove('hidden');
            });
        })();
    </script>
</x-app-layout>
