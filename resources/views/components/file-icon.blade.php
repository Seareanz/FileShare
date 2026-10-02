@props(['name'])

@php
$ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
$map = [
    'pdf'  => ['bg-rose-500/15 text-rose-300', 'PDF'],
    'doc'  => ['bg-blue-500/15 text-blue-300', 'DOC'],
    'docx' => ['bg-blue-500/15 text-blue-300', 'DOC'],
    'xls'  => ['bg-emerald-500/15 text-emerald-300', 'XLS'],
    'xlsx' => ['bg-emerald-500/15 text-emerald-300', 'XLS'],
    'ppt'  => ['bg-orange-500/15 text-orange-300', 'PPT'],
    'pptx' => ['bg-orange-500/15 text-orange-300', 'PPT'],
    'zip'  => ['bg-amber-500/15 text-amber-300', 'ZIP'],
    'jpg'  => ['bg-violet-500/15 text-violet-300', 'IMG'],
    'jpeg' => ['bg-violet-500/15 text-violet-300', 'IMG'],
    'png'  => ['bg-violet-500/15 text-violet-300', 'IMG'],
    'gif'  => ['bg-violet-500/15 text-violet-300', 'IMG'],
    'webp' => ['bg-violet-500/15 text-violet-300', 'IMG'],
    'txt'  => ['bg-slate-500/15 text-slate-300', 'TXT'],
];
[$cls, $label] = $map[$ext] ?? ['bg-slate-500/15 text-slate-300', 'FILE'];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex w-11 shrink-0 items-center justify-center rounded-lg py-1.5 text-[10px] font-bold tracking-wider ' . $cls]) }}>
    {{ $label }}
</span>
