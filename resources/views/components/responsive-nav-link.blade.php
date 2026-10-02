@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full rounded-lg border-l-2 border-indigo-500 bg-indigo-500/10 px-3 py-2 text-start text-base font-medium text-indigo-300 transition'
            : 'block w-full rounded-lg border-l-2 border-transparent px-3 py-2 text-start text-base font-medium text-slate-400 hover:bg-slate-800/50 hover:text-white transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
